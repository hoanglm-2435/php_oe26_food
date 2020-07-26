<?php

namespace App\Http\Controllers;

use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        $products = session('cart');

        return view('client.cart-page', compact('products'));
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
        foreach ($products as $key => $value) {
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
            $product = $this->productRepo->getById($id);
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
