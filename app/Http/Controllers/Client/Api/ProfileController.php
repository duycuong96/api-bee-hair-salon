<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomerRepository;
use Validator;
use Carbon\Carbon;

class ProfileController extends Controller
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
		$user = auth('api_customers')->user();
		return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'full_name' => 'sometimes|required|string',
            'avatar' => 'file|mimes:jpg,png,jpeg',
            // 'birthday' => 'date_format:dd-mm-yyyy',
            'phone' => 'string|max:15',
            'address' => 'string|max:255',
            'ward_id' => 'numeric',
        ], [
            'required' => ':attribute không được để trống',
            'string' => ':attribute không hợp lệ',
            'date' => ':attribute không đúng định dạng ngày-tháng-năm',
            'numeric' => ':attribute không đúng định dạng',
            'mimes' => ':attribute không đúng định dạng jpg, jpeg, png',
            'file' => ':attribute không phải là file',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $data = $request->all(['full_name', 'birthday', 'phone', 'address', 'ward_id']);
        $customer = \Auth::guard('api_customers')->user();
        $birthday = $data['birthday'];
        if ($birthday) {
            try {
                $data['birthday'] = Carbon::createFromFormat('d-m-Y', $birthday)->startOfDay()->format('Y-m-d');
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Đã xảy ra lỗi, vui lòng liên hệ quản trị',
                ], 200);
            }
        }
        try {
            $data['avatar'] = $request->file('avatar')->store('avatar_customer', 'public');
            $customerUpdate = $this->customerRepository->update($customer, $data);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Đã xảy ra lỗi, vui lòng liên hệ quản trị',
            ], 200);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công',
            'data' => $customerUpdate,
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:6|max:255',
            'password_new' => 'required|min:6|max:255|confirmed',
        ], [
            'required' => ':attribute không được để trống',
            'min' => ':attribute phải trên :min ký tự',
            'max' => ':attribute max :max ký tự',
            'confirmed' => ':attribute không khớp'
        ], [
            'password' => 'Mật khẩu cũ',
            'password_new' => 'Mật khẩu mới'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $password = $request->input('password');
        $customer = \Auth::guard('api_customers')->user();
        if (\Hash::check($password, $customer->password)) {
            $customer->password = bcrypt($request->input('password_new'));
            $customer->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
            ]);
        } else {
            return response()->json([
                'password' => 'Sai mật khẩu cũ',
            ], 422);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'Cập nhật không thành công',
        ]);
    }
}
