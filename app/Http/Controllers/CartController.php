<?php
namespace App\Http\Controllers;

use App\Models\{Corzina, Grypirovca, Ord, Tovar};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash};

class CartController extends Controller
{
    public function index()
    {
        $items = Corzina::with('tovar')
            ->where('id_user', Auth::id())
            ->orderByDesc('id')->get();

        $total = $items->sum(fn($i) => $i->tovar->price * $i->colvo);

        return view('pages.cart', compact('items', 'total'));
    }

    public function add(Request $r)
    {
        $tovar = Tovar::where('is_published', 1)->findOrFail((int)$r->input('id'));

        $row = Corzina::where('id_user', Auth::id())
            ->where('id_tovar', $tovar->id)->first();

        $have = $row ? $row->colvo : 0;

        if ($have + 1 > $tovar->nalichie) {
            $msg = "В наличии только {$tovar->nalichie} шт.";
            return $r->expectsJson()
                ? response()->json(['ok' => false, 'message' => $msg], 422)
                : back()->withErrors(['cart' => $msg]);
        }

        if ($row) $row->increment('colvo');
        else Corzina::create([
            'id_user'  => Auth::id(),
            'id_tovar' => $tovar->id,
            'colvo'    => 1,
        ]);

        return $r->expectsJson()
            ? response()->json(['ok' => true, 'count' => $this->cartCount(), 'message' => 'Товар добавлен в корзину'])
            : back()->with('success', 'Товар добавлен в корзину');
    }

    public function setQty(Request $r)
    {
        $row = Corzina::with('tovar')
            ->where('id_user', Auth::id())
            ->findOrFail((int)$r->input('row'));

        $new = $row->colvo + (int)$r->input('delta');

        if ($new < 1) {
            $row->delete();
            return $r->expectsJson()
                ? response()->json(['ok' => true, 'removed' => true, 'count' => $this->cartCount()])
                : back();
        }

        if ($new > $row->tovar->nalichie) {
            $msg = "В наличии только {$row->tovar->nalichie} шт.";
            return $r->expectsJson()
                ? response()->json(['ok' => false, 'message' => $msg], 422)
                : back()->withErrors(['cart' => $msg]);
        }

        $row->update(['colvo' => $new]);

        return $r->expectsJson()
            ? response()->json(['ok' => true, 'colvo' => $new, 'count' => $this->cartCount()])
            : back();
    }

    public function remove(Request $r)
    {
        Corzina::where('id_user', Auth::id())
            ->where('id', (int)$r->input('row'))->delete();

        return $r->expectsJson()
            ? response()->json(['ok' => true, 'count' => $this->cartCount()])
            : back();
    }

    public function createOrder(Request $r)
    {
        if (!Hash::check((string)$r->input('password'), Auth::user()->password)) {
            $msg = 'Неверный пароль';
            return $r->expectsJson()
                ? response()->json(['ok' => false, 'errors' => ['password' => $msg]], 422)
                : back()->withErrors(['password' => $msg]);
        }

        $items = Corzina::with('tovar')->where('id_user', Auth::id())->get();
        if ($items->isEmpty()) {
            return $r->expectsJson()
                ? response()->json(['ok' => false, 'message' => 'Корзина пуста'], 422)
                : back()->withErrors(['cart' => 'Корзина пуста']);
        }

        foreach ($items as $i) {
            if ($i->colvo > $i->tovar->nalichie) {
                $msg = "Товара «{$i->tovar->name}» в наличии только {$i->tovar->nalichie} шт.";
                return $r->expectsJson()
                    ? response()->json(['ok' => false, 'message' => $msg], 422)
                    : back()->withErrors(['cart' => $msg]);
            }
        }

        $idOrder = DB::transaction(function () use ($items) {
            $idOrder = (int)(DB::table('grypirovca')->max('id_order') ?? 0) + 1;
            foreach ($items as $i) {
                Grypirovca::create([
                    'id_order' => $idOrder,
                    'id_user'  => Auth::id(),
                    'id_tovar' => $i->id_tovar,
                    'colvo'    => $i->colvo,
                ]);
                Ord::create([
                    'id_order' => $idOrder,
                    'status'   => 'Новый',
                    'id_tovar' => $i->id_tovar,
                    'colvo'    => $i->colvo,
                    'reson'    => '',
                ]);
                $i->tovar->decrement('nalichie', $i->colvo);
            }
            Corzina::where('id_user', Auth::id())->delete();
            return $idOrder;
        });

        return $r->expectsJson()
            ? response()->json([
                'ok'       => true,
                'message'  => "Заказ №{$idOrder} оформлен",
                'redirect' => route('orders'),
            ])
            : redirect()->route('orders')->with('success', "Заказ №{$idOrder} оформлен");
    }

    private function cartCount(): int
    {
        return (int)Corzina::where('id_user', Auth::id())->sum('colvo');
    }
}