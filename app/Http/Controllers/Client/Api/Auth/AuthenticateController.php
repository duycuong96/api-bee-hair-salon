<?php

namespace App\Http\Controllers\Client\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class AuthenticateController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors()
            ], 422);
        }
        $credentials = $request->all(['email', 'password']);
        if (! $token = auth('api_customers')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('api_customers')->logout();
        return response()->json(['message' => 'Đăng xuất thành công']);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api_customers')->factory()->getTTL() * 60,
            'data' => auth('api_customers')->user()
        ], 200);
    }

    public function register(Request $request)
    {
        $user = $request->all(['full_name', 'email', 'password']);
        $validate = Validator::make($user, [
            'full_name' => 'required|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6'
        ], [
            'required' => ':attribute không được để trống',
            'email' => ':attribute không đúng định dạng email',
            'unique' => ':attribute đã tồn tại',
            'min' => ':attribute lớn hơn 6 ký tự',
        ], [
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'full_name' => 'Họ tên'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors()
            ], 422);
        }

        $user['password'] = bcrypt($user['password']);

        $inertCustomer = Customer::create($user);
        return response()->json([
            'success' => true,
            'data' => $inertCustomer
        ], 200);
    }
}
