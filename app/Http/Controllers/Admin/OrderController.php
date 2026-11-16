<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Grypirovca, Ord, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $r)
    {
        $filter  = (string)$r->input('status', '');
        $allowed = ['Новый', 'Подтверждён', 'Отменён'];

        $q = Ord::query()
            ->select(
                'id_order',
                DB::raw('MAX(date)   as date'),
                DB::raw('MAX(status) as status'),
                DB::raw('MAX(reson)  as reson'),
                DB::raw('SUM(colvo)  as cnt')
            )
            ->groupBy('id_order')
            ->orderByDesc('id_order');

        if (in_array($filter, $allowed, true)) {
            $q->having('status', $filter);
        }

        $orders = $q->get();

        foreach ($orders as $o) {
            $o->items = Ord::with('tovar')->where('id_order', $o->id_order)->get();
            $uid      = Grypirovca::where('id_order', $o->id_order)->value('id_user');
            $o->fio   = $uid ? User::find($uid)->full_name : '—';
        }

        return view('admin.orders', compact('orders', 'filter'));
    }

    public function setStatus(Request $r, int $id)
    {
        $data = $r->validate([
            'status' => 'required|in:Новый,Подтверждён,Отменён',
            'reason' => 'nullable|string|max:500',
        ], [], ['status' => 'статус', 'reason' => 'причина']);

        Ord::where('id_order', $id)->update([
            'status' => $data['status'],
            'reson'  => $data['reason'] ?? '',
        ]);

        return redirect()
            ->route('admin.orders', array_filter(['status' => $r->input('back_status')]))
            ->with('success', "Статус заказа №{$id} обновлён");
    }
}