<?php

namespace App\Http\Controllers;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Rating\RatingRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
    protected $productRepo;
    protected $ratingRepo;
    protected $categoryRepo;
    protected $sizeRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        RatingRepositoryInterface $ratingRepo,
        CategoryRepositoryInterface $categoryRepo,
        SizeRepositoryInterface $sizeRepo
    ) {
        $this->productRepo = $productRepo;
        $this->ratingRepo = $ratingRepo;
        $this->categoryRepo = $categoryRepo;
        $this->sizeRepo = $sizeRepo;
    }

    public function index(Request $request)
    {
        $products = $this->productRepo->showList(
            'created_at',
            'DESC',
            config('paginates.pagination_shop')
        );

        if ($request->sortBy) {
            $sortBy = $request->sortBy;

            switch ($sortBy)
            {
                case config('attribute_product.desc'):
                    $products = $this->productRepo->showList(
                        'created_at',
                        'DESC',
                        config('paginates.pagination_shop')
                    );
                    break;
                case config('attribute_product.asc'):
                    $products = $this->productRepo->showList(
                        'created_at',
                        'ASC',
                        config('paginates.pagination_shop')
                    );
                    break;
                case config('attribute_product.price_asc'):
                    $products = $this->productRepo->showList(
                        'price_sale',
                        'ASC',
                        config('paginates.pagination_shop')
                    );
                    break;
                case config('attribute_product.price_desc'):
                    $products = $this->productRepo->showList(
                        'price_sale',
                        'DESC',
                        config('paginates.pagination_shop')
                    );
                    break;
                case config('attribute_product.rating_desc'):
                    $ratingDesc = $this->ratingRepo
                        ->getProductByRatingDesc();
                    $ids = [];

                    foreach ($ratingDesc as $rating) {
                        $ids[] = $rating->product_id;
                    }
                    $products = $this->productRepo->showProductByRatingFilter($ids);
                    break;
            }
        }
        if ($request->filterBy) {
            $filterBy = $request->filterBy;

            switch ($filterBy)
            {
                case config('attribute_product.food.name'):
                    $products = $this->productRepo
                        ->getProductByAttr('category_id', config('attribute_product.food.id'));
                    break;
                case config('attribute_product.drink.name'):
                    $products = $this->productRepo
                        ->getProductByAttr('category_id', config('attribute_product.drink.id'));
                    break;
                case config('attribute_product.size_s.name'):
                    $products = $this->productRepo
                        ->getProductByAttr('size_id', config('attribute_product.size_s.id'));
                    break;
                case config('attribute_product.size_m.name'):
                    $products = $this->productRepo
                        ->getProductByAttr('size_id', config('attribute_product.size_m.id'));
                    break;
                case config('attribute_product.size_l.name'):
                    $products = $this->productRepo
                        ->getProductByAttr('size_id', config('attribute_product.size_l.id'));
                    break;
                case config('attribute_product.size_xl.name'):
                    $products = $this->productRepo
                        ->getProductByAttr('size_id', config('attribute_product.size_xl.id'));
                    break;
            }
        }
        $categories = $this->categoryRepo->getAll();
        $sizes = $this->sizeRepo->getAll();

        return view('client.shop', compact('products', 'categories', 'sizes'));
    }

    public function show($id)
    {
        $products = $this->productRepo->showList(
            'created_at',
            'DESC',
            config('paginates.pagination')
        );
        $product = $this->productRepo->getById($id);
        $ratings = $this->ratingRepo->getRatingOfProduct($id);
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
