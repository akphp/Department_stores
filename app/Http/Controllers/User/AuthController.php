<?php

namespace App\Http\Controllers\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }



    public function register(UserRequest $request)
    {

        $user = User::create([
            'username' =>  $request->username,
            'name' =>  $request->name,
            'email' =>  $request->email,
            'phone' => $request->phone,
            'is_active' =>  0,
            'mobile' => $request->address,
            'password' => bcrypt($request->password),
        ]);


        if (!$token = $this->guard()->login($user)) {
            return $this->apiResponse(null, null, 401);
            return response()->json(['message' => 'error '], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password', 'is_active');
        $credentials['is_active'] = 1;
        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }


    public function logout()
    {
        auth('admin-api')::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return auth::guard('user-api');
    }
}
