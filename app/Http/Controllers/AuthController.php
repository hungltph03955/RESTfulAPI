<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends ApiController
{

    /**
     * @var JWTAuth
     */
    private $jwtAuth;

    public function __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    const TIME_ZONE_CHECK_OPT = 'Asia/Ho_Chi_Minh';

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::ADMIN_USER;
        $user = User::create($data);
        return response()->json(['data' => $user], Response::HTTP_CREATED);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::select('*')->where('email', $request->get('email'))->first();
        $credentials = $request->only('email', 'password');
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if ($user->admin === false) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json([
            'token_type' => 'bearer',
            'access_token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60 * 8,
        ]);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();
        return $this->showMessage('Successfully logged out', Response::HTTP_OK);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        $token = Auth::guard('api')->refresh();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 * 8,
        ]);

    }

}
