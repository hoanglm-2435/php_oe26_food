<?php

namespace App\Http\Controllers;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $productRepo;
    protected $orderRepo;
    protected $orderItemRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        OrderRepositoryInterface $orderRepo,
        OrderItemRepositoryInterface $orderItemRepo
    ) {
        $this->productRepo = $productRepo;
        $this->orderRepo = $orderRepo;
        $this->orderItemRepo = $orderItemRepo;
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
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;
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
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => trans('client.purchased_failed')]);
        }

        return response()->json(['result' => trans('client.purchased_success')]);
    }
}
