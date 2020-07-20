<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')
            ->paginate(config('paginates.pagination'));

        return view('admin.order_management.show_order', compact('orders'));
    }

    public function showDetails($id)
    {
        $orderItem = OrderItem::where('order_id', $id)->get();
        $orderDetails = [];
        $grandTotal = config('numbers.zero');

        foreach ($orderItem as $id => $item) {
            $orderDetails[] = [
                'productName' => $item->product->name,
                'productQuantity' => $item->quantity,
                'productPrice' => $item->product->price_sale,
                'totalPrice' => $item->total_price,
            ];
            $grandTotal += $item->total_price;
        }

        return response()->json([
            'orderDetails' => $orderDetails,
            'grandTotal' => $grandTotal,
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($request->status) {
            if ($order->status == config('status.pending')) {
                $order->update(['status' => config('status.approved')]);

                return true;
            } elseif ($order->status == config('status.approved')) {
                $order->update(['status' => config('status.pending')]);

                return true;
            }
        }

        return false;
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

                return true;
            }
        }

        return false;
    }
}
