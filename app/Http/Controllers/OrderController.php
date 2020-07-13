<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\InvalidTag;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')
            ->paginate(config('paginates.pagination'));

        return view('admin.order_management.show_order', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($request->status) {
            if ($order->status == config('status.pending')) {
                $order->update(['status' => config('status.approved')]);
            } elseif ($order->status == config('status.approved')) {
                $order->update(['status' => config('status.pending')]);
            }
        }
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', trans('message.deleted'));
    }

    public function historyOrder()
    {
        $orders = Order::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(config('paginates.pagination'));

        return view('client.history-order', compact('orders'));
    }

    public function cancelOrder(Request $request, $id)
    {
        $orderUser = Order::findOrFail($id);

        if ($request->status) {
            if ($orderUser->status == config('status.pending')) {
                $orderUser->update(['status' => config('status.canceled')]);
            }
        }
    }
}
