<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\BranchSalon;
use App\Models\Customer;
use App\Repositories\BranchSalonRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    protected $reviewRepository;
    protected $branchSalonRepository;
    public function __construct(ReviewRepository $reviewRepository, BranchSalonRepository $branchSalonRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->branchSalonRepository = $branchSalonRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = $this->reviewRepository->all();
        return response()->json([
            'status'    => true,
            'data'      => $reviews,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'salon_id'      => 'required|numeric',
                'customer_id'   => 'required|numeric',
                'employee_id'   => 'required|numeric',
                'rating_stars'  => 'required',
                'detail'        => 'min:5',
            ],
            [
                'required'      => ":attribute không được để trống",
                'min'           => ":attribute quá ngắn",
                'numeric'       => ":attribute không hợp lệ",
            ],
            [
                'salon_id'      => "Salon",
                'customer_id'   => "Khách hàng",
                'employee_id'   => "Nhân viên",
                'rating_stars'  => "Mức đánh giá",
                'detail'        => "Đánh giá chi tiết",
            ],
        );

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $data = $request->all([
            'salon_id',
            'customer_id',
            'employee_id',
            'rating_stars',
            'detail',
        ]);
        $branchSalon = BranchSalon::find($data['salon_id']);
        $customer = Customer::find($data['customer_id']);

        if (empty($branchSalon)) {
            return response()->json(['salon_id' => "Salon không tồn tại"], 422);
        }
        if (empty($customer)) {
            return response()->json(['customer_id' => "Nhân viên không tồn tại"], 422);
        }

        $review = $this->reviewRepository->create($data);

        return response()->json([
            'status'    => true,
            'massage'   => "Đánh giá thành công. Cảm ơn bạn đã sự dụng dịch vụ của chúng tôi!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $review = $this->reviewRepository->find($id);
        return response()->json([
            'status'    => true,
            'data'      => $review,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'salon_id'      => 'required|numeric',
                'customer_id'   => 'required|numeric',
                'employee_id'   => 'required|numeric',
                'rating_stars'  => 'required',
                'detail'        => 'min:5',
            ],
            [
                'required'      => ":attribute không được để trống",
                'min'           => ":attribute quá ngắn",
                'numeric'       => ":attribute không hợp lệ",
            ],
            [
                'salon_id'      => "Salon",
                'customer_id'   => "Khách hàng",
                'employee_id'   => "Nhân viên",
                'rating_stars'  => "Mức đánh giá",
                'detail'        => "Đánh giá chi tiết",
            ],
        );

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $data = $request->all([
            'salon_id',
            'customer_id',
            'employee_id',
            'rating_stars',
            'detail',
        ]);
        $branchSalon = BranchSalon::find($data['salon_id']);
        $customer = Customer::find($data['customer_id']);

        if (empty($branchSalon)) {
            return response()->json(['salon_id' => "Salon không tồn tại"], 422);
        }
        if (empty($customer)) {
            return response()->json(['customer_id' => "Nhân viên không tồn tại"], 422);
        }

        $review = $this->reviewRepository->update($data, $id);

        return response()->json([
            'status'    => true,
            'massage'   => "Cập nhật đánh giá thành công",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = $this->reviewRepository->delete($id);
        return response()->json([
            'status'    => true,
            'massage'   => "Xoá đánh giá thành công",
        ]);
    }
}
