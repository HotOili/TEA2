<?php
namespace App\Http\Controllers;

use App\Models\{Grypirovca, Ord, Tovar};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB};

class OrderController extends Controller
{
    public function index()
    {
        $orders = Ord::query()
            ->select('id_order',
                     DB::raw('MAX(date) as date'),
                     DB::raw('MAX(status) as status'),
                     DB::raw('MAX(reson) as reson'),
                     DB::raw('SUM(colvo) as total_qty'))
            ->whereIn('id_order', function ($q) {
                $q->select('id_order')->from('grypirovca')
                  ->where('id_user', Auth::id());
            })
            ->groupBy('id_order')
            ->orderByDesc('id_order')
            ->get();

        foreach ($orders as $o) {
            $o->items = Ord::with('tovar')
                ->where('id_order', $o->id_order)->get();
        }

        return view('pages.orders', compact('orders'));
    }

    public function destroy(int $id)
    {
        $owner = Grypirovca::where('id_order', $id)
            ->where('id_user', Auth::id())->exists();

        if (!$owner) {
            return response()->json(['ok' => false, 'message' => 'Заказ не найден'], 404);
        }

        $statuses = Ord::where('id_order', $id)->pluck('status')->unique()->all();
        if ($statuses !== ['Новый']) {
            return response()->json(['ok' => false, 'message' => 'Удалить можно только новые заказы'], 422);
        }

        DB::transaction(function () use ($id) {
            foreach (Ord::where('id_order', $id)->get() as $o) {
                Tovar::where('id', $o->id_tovar)->increment('nalichie', $o->colvo);
            }
            Ord::where('id_order', $id)->delete();
            Grypirovca::where('id_order', $id)->delete();
        });

        return response()->json(['ok' => true, 'message' => 'Заказ удалён']);
    }
}