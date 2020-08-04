<?php

namespace App\Http\Controllers;

use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class CheckoutController extends Controller
{
    protected $productRepo;
    protected $orderRepo;
    protected $orderItemRepo;
    protected $notiRepo;
    protected $userRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        OrderRepositoryInterface $orderRepo,
        OrderItemRepositoryInterface $orderItemRepo,
        NotificationRepositoryInterface $notiRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->productRepo = $productRepo;
        $this->orderRepo = $orderRepo;
        $this->orderItemRepo = $orderItemRepo;
        $this->notiRepo = $notiRepo;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $cart = session('cart');

        return view('client.checkout-page', compact('cart'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $data = $request->all();
            $data['user_id'] = $user->id;
            $data['quantity'] = config('payment_type.quantity_order_default');
            $data['status'] = config('status.pending');
            $order = $this->orderRepo->create($data);
            $orderId = $order->id;
            $orderItems = [];

            foreach (session('cart') as $key => $cart) {
                $orderItems[] = [
                    'order_id' => $orderId,
                    'product_id' => $cart['id'],
                    'quantity' => $cart['quantity'],
                    'total_price' => $cart['quantity'] * $cart['price'],
                ];
                $product = $this->productRepo->getById($cart['id']);
                $product->update([
                    'quantity' =>  $product->quantity - $cart['quantity']
                ]);
            }
            $this->orderItemRepo->insert($orderItems);
            $request->session()->forget('cart');
            $request->session()->forget('totalPrice');
            $notify['order_id'] = $order->id;
            $notify['user'] = $user->name;
            $notification = $this->notiRepo->create([
                'user_id' => $user->id,
                'notification' => json_encode($notify)
            ]);
            $notify['notify_id'] = $notification->id;
            $options = array(
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true,
                'useTLS' => true,
            );
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
            $admins = $this->userRepo->getWhereEqual('role_id', config('roles.admin'));

            foreach ($admins as $admin) {
                $notification->users()->attach(
                    $admin->id,
                    ['status' => config('realtime_notify.status.notify_unread')]
                );
                $pusher->trigger(
                    'notify-for-admin' . $admin->id,
                    'order-notify',
                    $notify
                );
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => trans('client.purchased_failed')]);
        }

        return response()->json(['result' => trans('client.purchased_success')]);
    }
}
