<?php

namespace App\Http\Controllers;

use App\Repositories\Rating\RatingRepositoryInterface;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $ratingRepo;

    public function __construct(RatingRepositoryInterface $ratingRepo)
    {
        $this->ratingRepo = $ratingRepo;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $this->ratingRepo->create($data);
    }
}
