<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Repositories\AdminRepository;

class ProfileController extends Controller
{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'avatar' => 'file|mimes:jpg,png,jpeg',
            'dob' => 'date',
            'phone' => 'string|max:15',
            'address' => 'string|max:255',
        ], [
            'required' => ':attribute không được để trống',
            'string' => ':attribute không hợp lệ',
            'date' => ':attribute không đúng định dạng dd-mm-yyyy',
            'numeric' => ':attribute không đúng định dạng',
            'mimes' => ':attribute không đúng định dạng jpg, jpeg, png',
            'file' => ':attribute không phải là file',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $data = $request->all(['full_name', 'avatar', 'dob', 'phone', 'address']);
        $birthday = $data['dob'];
        if ($birthday) {
            try {
                $data['dob'] = Carbon::createFromFormat('d-m-Y', $birthday)->startOfDay()->format('Y-m-d');
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Đã xảy ra lỗi, vui lòng liên hệ quản trị',
                ], 200);
            }
        }
        $customer = \Auth::guard('api_admin')->user();
        try {
            $data['avatar'] = $request->file('avatar')->store('avatar_admin', 'public');
            $customerUpdate = $this->adminRepository->update($customer, $data);
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
            'max' => ':attribute max :max ký tự'
        ], [
            'password' => 'Mật khẩu cũ',
            'password_new' => 'Mật khẩu mới'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $password = $request->input('password');
        $admin = \Auth::guard('api_admin')->user();
        if (\Hash::check($password, $admin->password)) {
            $admin->password = bcrypt($request->input('password_new'));
            $admin->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
            ]);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'Cập nhật không thành công',
        ]);
    }
}
