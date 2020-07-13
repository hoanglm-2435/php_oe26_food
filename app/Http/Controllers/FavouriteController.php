<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function index()
    {
        $products = session('favourites');

        return view('client.favourites', compact('products'));
    }

    public function addToFavourites($id, Request $request)
    {
        if ($request->ajax()) {
            $product = Product::findOrFail($id);
            $favouriteList = session()->get('favourites');

            if (!$favouriteList) {
                $favouriteList = [
                    $id => [
                        'id' => $product->id,
                        "name" => $product->name,
                        "price" => $product->price_sale,
                        "photo" => $product->images->first()->image_path
                    ]
                ];
                session()->put('favourites', $favouriteList);
                $countFavourites = count(session('favourites'));

                return response()->json([
                    'result' => trans('client.add_to_favourites_success'),
                    'countFavourites' => $countFavourites
                ]);
            }
            if (isset($favouriteList[$id])) {
                return response()->json(['error' => trans('client.product_already_favourites_list')]);
            }

            $favouriteList[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price_sale,
                "photo" => $product->images->first()->image_path
            ];
            session()->put('favourites', $favouriteList);
            $countFavourites = count(session('favourites'));

            return response()->json([
                'result' => trans('client.add_to_favourites_success'),
                'countFavourites' => $countFavourites
            ]);
        }
    }

    public function destroy($id, Request $request)
    {
        $products = session('favourites');
        foreach ($products as $key => $value)
        {
            if ($value['id'] == $id) {
                unset($products[$key]);
                break;
            }
        }
        $request->session()->remove('favourites');
        $request->session()->put('favourites', $products);

        return redirect()->route('favourites')->with('result', trans('message.deleted'));
    }

    public function clearFavourites(Request $request)
    {
        $request->session()->forget('favourites');

        return redirect()->back()->with('result', trans('message.deleted'));
    }
}
