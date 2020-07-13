<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $products = session('cart');

        return view('client.cart-page', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $data['quantity'] = 1;
        $data['status'] = config('status.pending');
        $order = Order::create($data);
        $orderId = $order->id;
        $orderItems = [];

        foreach (session('cart') as $key => $cart)
        {
            $orderItems[] = [
                'order_id' => $orderId,
                'product_id' => $cart['id'],
                'quantity' => $cart['quantity'],
                'total_price' => $cart['price'],
            ];
            $product = Product::find($cart['id']);
            $product->update([
               'quantity' =>  $product->quantity - $cart['quantity']
            ]);
        }
        OrderItem::insert($orderItems);
        $request->session()->forget('cart');
        $request->session()->forget('totalPrice');

        return response()->json(['result' => trans('client.purchased_success')]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($request->quantity < 1) {

                return response()->json(['error' => trans('client.minimum_quantity')], 200);
            } else {
                $cart = session()->get('cart');
                $oldQuantity = $cart[$request->id]['quantity'];
                $newQuantity = $request->quantity;
                $priceItem = $request->price;
                $totalPrice = $priceItem * ($newQuantity - $oldQuantity);
                $grandTotal = session()->get('totalPrice');
                $grandTotal += $totalPrice;
                session()->put('totalPrice', $grandTotal);
                $cart[$request->id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);

                return response()->json([
                    'result' => trans('client.quantity_updated'),
                    'oldQuantity' => $oldQuantity,
                    'totalPrice' => $totalPrice,
                    'grandTotal' => $grandTotal
                ]);
            }
        }
    }

    public function destroy($id, Request $request)
    {
        $products = session('cart');
        foreach ($products as $key => $value)
        {
            if ($value['id'] == $id) {
                unset($products[$key]);
                break;
            }
        }
        $request->session()->remove('cart');
        $request->session()->put('cart', $products);

        return redirect()->back()->with('result', trans('message.deleted'));
    }

    public function addCart($id, Request $request)
    {
        if ($request->ajax()) {
            $product = Product::findOrFail($id);
            $cart = session()->get('cart');

            if (!$cart) {
                $cart = [
                    $id => [
                        'id' => $product->id,
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price_sale,
                        "photo" => $product->images->first()->image_path
                    ]
                ];
                $totalPrice = session()->get('totalPrice');
                $totalPrice += $product->price_sale;
                session()->put('totalPrice', $totalPrice);
                session()->put('cart', $cart);
                $countCart = count(session('cart'));

                return response()->json([
                    'result' => trans('client.add_to_cart_success'),
                    'totalPrice' => $totalPrice,
                    'countCart' => $countCart,
                ]);
            }
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
                $totalPrice = session()->get('totalPrice');
                $totalPrice += $product->price_sale;
                session()->put('totalPrice', $totalPrice);
                session()->put('cart', $cart);
                $countCart = count(session('cart'));

                return response()->json([
                    'result' => trans('client.add_to_cart_success'),
                    'totalPrice' => $totalPrice,
                    'countCart' => $countCart,
                ]);
            }

            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price_sale,
                "photo" => $product->images->first()->image_path
            ];
            $totalPrice = session()->get('totalPrice');
            $totalPrice += $product->price_sale;
            session()->put('totalPrice', $totalPrice);
            session()->put('cart', $cart);
            $countCart = count(session('cart'));

            return response()->json([
                'result' => trans('client.add_to_cart_success'),
                'totalPrice' => $totalPrice,
                'countCart' => $countCart,
            ]);
        }
    }

    public function clearCart(Request $request)
    {
        $request->session()->forget('cart');
        $request->session()->forget('totalPrice');

        return redirect()->back()->with('result', trans('message.deleted'));
    }
}
