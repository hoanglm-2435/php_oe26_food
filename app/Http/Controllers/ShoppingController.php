<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::paginate(config('paginates.pagination_shop'));

        if ($request->sortBy) {
            $sortBy = $request->sortBy;

            switch ($sortBy)
            {
                case config('attribute_product.desc'):
                    $products = Product::orderBy('created_at', 'DESC')
                        ->paginate(config('paginates.pagination_shop'));
                    break;
                case config('attribute_product.asc'):
                    $products = Product::orderBy('created_at', 'ASC')
                        ->paginate(config('paginates.pagination_shop'));
                    break;
                case config('attribute_product.price_asc'):
                    $products = Product::orderBy('price', 'ASC')
                        ->paginate(config('paginates.pagination_shop'));
                    break;
                case config('attribute_product.price_desc'):
                    $products = Product::orderBy('price', 'DESC')
                        ->paginate(config('paginates.pagination_shop'));
                    break;
                case config('attribute_product.rating_desc'):
                    $ratingDesc = Rating::select('product_id',
                        DB::raw('AVG(rating) as rating_avg'))
                        ->groupBy('product_id')
                        ->orderBy('rating_avg', 'DESC')
                        ->get();
                    $ids = [];

                    foreach ($ratingDesc as $rating) {
                        $ids[] = $rating->product_id;
                    }
                    $product_id = implode(',', $ids);
                    $products = Product::whereIn('id', $ids)
                        ->orderByRaw("FIELD(id, $product_id)")
                        ->paginate(config('paginates.pagination_shop'));
                    break;
                default:
                    $products = Product::paginate(config('paginates.pagination_shop'));
            }
        }
        if ($request->filterBy) {
            $filterBy = $request->filterBy;

            switch ($filterBy)
            {
                case config('attribute_product.food.name'):
                    $products = Product::where('category_id', config('attribute_product.food.id'))
                        ->paginate(config('paginates.pagination_shop'));
                    break;
                case config('attribute_product.drink.name'):
                    $products = Product::where('category_id', config('attribute_product.drink.id'))
                        ->paginate(config('paginates.pagination_shop'));
                    break;
                case config('attribute_product.size_s.name'):
                    $products = Product::where('size_id', config('attribute_product.size_s.id'))
                        ->paginate(config('paginates.pagination_shop'));
                    break;
                case config('attribute_product.size_m.name'):
                    $products = Product::where('size_id', config('attribute_product.size_m.id'))
                        ->paginate(config('paginates.pagination_shop'));
                    break;
                case config('attribute_product.size_l.name'):
                    $products = Product::where('size_id', config('attribute_product.size_l.id'))
                        ->paginate(config('paginates.pagination_shop'));
                    break;
                case config('attribute_product.size_xl.name'):
                    $products = Product::where('size_id', config('attribute_product.size_xl.id'))
                        ->paginate(config('paginates.pagination_shop'));
                    break;
            }
        }
        $categories = Category::all();
        $sizes = Size::all();

        return view('client.shop', compact('products', 'categories', 'sizes'));
    }

    public function show($id)
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        $product = $products->find($id);
        $ratings = Rating::where('product_id', $id)
            ->orderBy('created_at', 'DESC')->get();
        $countRate = $ratings->count();

        if ($countRate != config('numbers.zero')) {
            $ratingSum = config('numbers.zero');

            foreach ($ratings as $rating) {
                $ratingSum += $rating->rating;
            }
            $ratingAverage = round($ratingSum / $countRate, config('numbers.precision'));
        } else {
            $ratingAverage = config('numbers.max_rate');
        }

        return view('client.product-details', compact(
            'products',
            'product',
            'ratings',
            'countRate',
            'ratingAverage'
        ));
    }
}
