<?php

namespace App\Repositories\Rating;

interface RatingRepositoryInterface
{
    public function getProductBestRating();

    public function getProductByRatingDesc();

    public function getRatingOfProduct($id);
}
