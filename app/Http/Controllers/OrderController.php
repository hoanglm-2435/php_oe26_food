<?php

namespace App\Http\Controllers;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepo;
    protected $orderItemRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        OrderItemRepositoryInterface $orderItemRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->orderItemRepo = $orderItemRepo;
    }

    public function index()
    {
        $orders = $this->orderRepo->showList(
            'created_at',
            'DESC',
            config('paginates.pagination')
        );

        return view('admin.order_management.show_order', compact('orders'));
    }

    public function showDetails($id)
    {
        $orderItem = $this->orderItemRepo->getWhereEqual('order_id', $id);
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
        $order = $this->orderRepo->getById($id);

        if ($request->all()) {
            if ($order->status == config('status.pending')) {
                $this->orderRepo->update($id, ['status' => config('status.approved')]);

                return true;
            } elseif ($order->status == config('status.approved')) {
                $this->orderRepo->update($id, ['status' => config('status.pending')]);

                return true;
            }
        }

        return false;
    }

    public function destroy($id)
    {
        $order = $this->orderRepo->getById($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', trans('message.deleted'));
    }

    public function historyOrder()
    {
        $orders = $this->orderRepo->getHistoryOrder(auth()->user()->id);

        return view('client.history-order', compact('orders'));
    }

    public function cancelOrder(Request $request, $id)
    {
        $orderUser = $this->orderRepo->getById($id);

        if ($request->status) {
            if ($orderUser->status == config('status.pending')) {
                $this->orderRepo->update($id, ['status' => config('status.canceled')]);

                return true;
            }
        }

        return false;
    }
}
