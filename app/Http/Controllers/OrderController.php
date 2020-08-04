<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmOrder;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    protected $orderRepo;
    protected $orderItemRepo;
    protected $userRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        OrderItemRepositoryInterface $orderItemRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->orderItemRepo = $orderItemRepo;
        $this->userRepo = $userRepo;
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
        $user = $this->userRepo->getById($order->user_id);
        $admin = Auth::user();
        $orderDetails = $this->showDetails($order->id)->getData();

        if ($request->all()) {
            if ($order->status == config('status.pending')) {
                $this->orderRepo->update($id, ['status' => config('status.approved')]);
                Mail::to($user->email)->queue(new ConfirmOrder($user, $admin, $orderDetails));

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
