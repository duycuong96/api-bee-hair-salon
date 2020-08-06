<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ReviewRepository;

class ReviewController extends Controller
{
    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->ReviewRepository = $reviewRepository;
    }

    public function findReviewsCustomer()
    {
        $reviews = $this->ReviewRepository->findReviewsCustomer();
        return $reviews;
    }

    public function findReviewsSalon(Request $request)
    {
        $reviews = $this->ReviewRepository->findReviewsSalon($request);
        return $reviews;
    }


}
