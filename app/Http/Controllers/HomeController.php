<?php

namespace App\Http\Controllers;

use App\Repositories\Rating\RatingRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

class HomeController extends Controller
{
    protected $productRepo;
    protected $ratingRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        RatingRepositoryInterface $ratingRepo
    ) {
        $this->productRepo = $productRepo;
        $this->ratingRepo = $ratingRepo;
    }

    public function index()
    {
        $products = $this->productRepo->showList(
            'created_at',
            'DESC',
            config('paginates.pagination')
        );
        $food = $products->where('category_id', config('attribute_product.food.id'))
            ->sortBy('DESC')
            ->take(config('paginates.pagination'));
        $drink = $products->where('category_id', config('attribute_product.drink.id'))
            ->sortBy('DESC')
            ->take(config('paginates.pagination'));
        $ratingProducts = $this->ratingRepo->getProductBestRating();
        $ids = [];

        foreach ($ratingProducts as $rating) {
            $ids[] = $rating->product_id;
        }
        $product_id = implode(',', $ids);
        $bestProducts = $products->whereIn('id', $ids)
            ->sortBy("FIELD(id, $product_id)")
            ->take(config('paginates.pagination_shop'));

        return view('client.homepage', compact(
            'products',
            'food',
            'drink',
            'bestProducts'
        ));
    }
}
