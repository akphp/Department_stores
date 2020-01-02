<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Mail\AdminCreated;
use App\Mail\UserCreated;
use App\Models\Admin;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register' , 'verify' , 'resend']]);
    }



    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'mobile' => 'required',
            // 'habbits' => 'required',
            // 'favorite_events' => 'required',
        ]);

        if ($validator->fails()) {
            // return $this->apiResponse(null, $validator->errors()->toJson(), 400);
            return response()->json( $validator->errors()->toJson()  , 400);
        }

        $user = Admin::create([
            'username' =>  $request->username,
           'name' =>  $request->name,
            'email' =>  $request->email,
            'phone' => $request->phone,
            'is_active' =>  INACTIVE,
            'verified' => INACTIVE ,
            'mobile' => $request->address,
            'verification_token' =>  Admin::generateVerificationCode(),
            'password' => bcrypt($request->password),
        ]);


        if (!$token = $this->guard()->login($user)) {
            return $this->apiResponse(null, null, 401);
            return response()->json(['message' => 'error '] , 401);
            // return abort(401);
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
        $credentials = $request->only('username', 'password' , 'is_active');
        $credentials['is_active'] = 1;
        if ($token = $this->guard()->attempt($credentials  )) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = new UserCollection($this->guard()->user());
        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('admin-api')::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */


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
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return auth::guard('admin-api');

    }



    public function verify($token)
    {
        $admin = Admin::where('verification_token' , $token)->firstOrFail();
        $admin->is_active = ACTIVE ;
        $admin->verified = ACTIVE ;
        $admin->verification_token = null;
        $admin->save();
        return $this->showMessage("The account has been verified succesfully ");
    }


    public function resend(Admin $admin)
    {
        if ($admin->isVerified()) {
            return $this->errorResponse('This user is already verified', 409);
        }

        retry(5, function() use ($admin) {
                Mail::to($admin)->send(new AdminCreated($admin));
            }, 100);

        return $this->showMessage('The verification email has been resend');
    }

}
