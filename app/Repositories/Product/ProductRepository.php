<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function getProductByAttr($filter, $attr)
    {
        return $this->model->where($filter, $attr)
            ->paginate(config('paginates.pagination_shop'));
    }

    public function showProductByRatingFilter($ids = [])
    {
        $product_id = implode(',', $ids);

        return $this->model->whereIn('id', $ids)
            ->orderByRaw("FIELD(id, $product_id)")
            ->paginate(config('paginates.pagination_shop'));
    }
}
