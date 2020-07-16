<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')
            ->take(config('paginates.pagination'))->get();
        $food = $products->where('category_id', config('attribute_product.food.id'))
            ->sortBy('DESC')
            ->take(config('paginates.pagination'));
        $drink = $products->where('category_id', config('attribute_product.drink.id'))
            ->sortBy('DESC')
            ->take(config('paginates.pagination'));
        $ratingProducts = Rating::select('product_id',
            DB::raw('AVG(rating > ' . config('attribute_product.best_rating') . ') as rating_avg'))
            ->groupBy('product_id')
            ->orderBy('rating_avg', 'DESC')
            ->get();
        $ids = [];

        foreach ($ratingProducts as $rating)
        {
            $ids[] = $rating->product_id;
        }

        $product_id = implode(',', $ids);
        $bestProducts = $products->whereIn('id', $ids)
            ->sortBy("FIELD(id, $product_id)")
            ->take(config('paginates.pagination_shop'));

        return view('client.homepage', compact('products', 'food', 'drink', 'bestProducts'));
    }
}
