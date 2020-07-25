<?php

namespace App\Repositories\Rating;

use App\Models\Rating;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class RatingRepository extends BaseRepository implements RatingRepositoryInterface
{
    public function getModel()
    {
        return Rating::class;
    }

    public function getProductBestRating()
    {
        return $this->model->select('product_id',
            DB::raw('AVG(rating > ' . config('attribute_product.best_rating') . ') as rating_avg'))
            ->groupBy('product_id')
            ->orderBy('rating_avg', 'DESC')
            ->get();
    }

    public function getProductByRatingDesc()
    {
        return $this->model->select('product_id',
            DB::raw('AVG(rating) as rating_avg'))
            ->groupBy('product_id')
            ->orderBy('rating_avg', 'DESC')
            ->get();
    }

    public function getRatingOfProduct($id)
    {
        return $this->model->where('product_id', $id)
            ->orderBy('created_at', 'DESC')->get();
    }
}
