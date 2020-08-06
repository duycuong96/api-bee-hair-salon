<?php

namespace App\Http\Controllers\Client\Api\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Validator;

class ForgotController extends Controller
{
    protected $user, $customerRepository;
    public function __construct(
        CustomerRepository $customerRepository
    )
    {
        $this->user = auth('api_customers')->user();
        $this->customerRepository = $customerRepository;
    }

    public function forgotPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email'
        ], [
            'required' => ':attribute không được để trống',
            'email' => ':attribute không đúng định dạng'
        ], [
            'email' => 'Email'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $email = $request->input('email');
        $customer = $this->customerRepository->getCustomerByEmail($email);
        if (empty($customer)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email không tồn tại'
            ]);
        }
        try {
            $customer->token_hash = sha1(time());
            $customer->token_expired = date('Y-m-d H:i:s', strtotime('+12 hour', time()));
            $customer->save();
            dispatch(new \App\Jobs\SendMailJob($customer));
        } catch(\Exception $e) {
            report($e);
            return abort(500);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Email khôi phục mật khẩu được gửi thành công'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'token' => 'required'
        ], [
            'required' =>':attribute không được để trống',
            'min' => ':attribute không được dưới :min ký tự'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $token = $request->input('token');
        $password = $request->input('password');
        $customer = $this->customerRepository->getCustomerByToken($token);
        if (empty($customer)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Token không hợp lệ!'
            ]);
        }
        $customer->token_hash = sha1(time());
        $customer->password = bcrypt($password);
        $customer->save();
         return response ()->json([
            'status' => 'success',
            'message' => 'Đổi mật khẩu thành công'
        ]);
    }
}
