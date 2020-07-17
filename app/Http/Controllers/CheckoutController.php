<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart');
        $orders = Order::all();

        return view('client.checkout-page', compact('cart', 'orders'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;
            $data['quantity'] = config('payment_type.quantity_order_default');
            $data['status'] = config('status.pending');
            $order = Order::create($data);
            $orderId = $order->id;
            $orderItems = [];

            foreach (session('cart') as $key => $cart) {
                $orderItems[] = [
                    'order_id' => $orderId,
                    'product_id' => $cart['id'],
                    'quantity' => $cart['quantity'],
                    'total_price' => $cart['quantity'] * $cart['price'],
                ];
                $product = Product::find($cart['id']);
                $product->update([
                    'quantity' =>  $product->quantity - $cart['quantity']
                ]);
            }
            OrderItem::insert($orderItems);
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
