<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function getProductByAttr($filter, $attr);

    public function showProductByRatingFilter($ids = []);
}
