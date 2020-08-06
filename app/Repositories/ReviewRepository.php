<?php

namespace App\Repositories;

use App\Models\Reviews;
use Illuminate\Support\Facades\Auth;

class ReviewRepository
{

    public function all()
    {
        $length = request()->input('length', 10);
        $reviews = Reviews::paginate($length);
        return $reviews;
    }

    public function create($data)
    {
        $review = Reviews::create($data);
        return $review;
    }

    public function find($id)
    {
        $review = Reviews::find($id);
        if (empty($review)) {
            return response()->json([
                'status'    => false,
                'message'   => 'Đánh giá không tồn tại',
            ]);
        }
        return $review;
    }

    public function update($data, $id)
    {
        $review = Reviews::find($id);
        if (empty($review)) {
            return response()->json([
                'status'    => false,
                'message'   => "Đánh giá không tồn tại",
            ]);
        }

        return $review->update($data);
    }

    public function delete($id)
    {
        $review = Reviews::find($id);
        if (empty($review)) {
            return response()->json([
                'status'    => false,
                'message'   => "Đánh giá không tồn tại",
            ]);
        }
        return $review->delete();
    }

    public function findReviewsCustomer()
    {
        $length = request()->input('length', 10);
        $customer = auth('api_customers')->user();
        $reviews = Reviews::query()
        ->leftJoin('customers', 'reviews.customer_id', '=', 'customers.id')
        ->leftJoin('branch_salons', 'reviews.salon_id', '=', 'branch_salons.id')
        ->select(
            'reviews.*',
            'customers.full_name as customer_name',
            'customers.avatar as customer_avatar',
            'branch_salons.name as salon_name',
            'branch_salons.thumb_img as salon_thumb_img',
            'branch_salons.address as salon_address'
        )
        ->where('customer_id', $customer->id)
        ->paginate($length);
        return $reviews;
    }

    public function findReviewsSalon($request)
    {
        $length = request()->input('length', 2);
        $reviews = Reviews::leftJoin('customers', 'reviews.customer_id', '=', 'customers.id')
        ->select('reviews.*', 'customers.full_name as customer_name', 'customers.avatar as customer_avatar')
        ->where('salon_id', $request->salon_id)
        ->paginate($length);
        return $reviews;
    }
}
