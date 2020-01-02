<?php
namespace App\Repositories;

use App\Http\Resources\UserCollection;
use App\Interfaces\AdminInterface;
use App\Interfaces\PlanInterface;
use App\Interfaces\UserInterface;
use App\Models\Admin;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class AdminRepository implements AdminInterface
{
    use ApiResponser;
    /**
     * repo. model
     *
     * @author Amr
     * @var Plan
     */
    private $admin;

    /**
     * PlanRepository constructor.
     * @param Plan $plan
     * @author Amr
     */


    function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    function register(Request $request){

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

        $user = $this->admin->create([
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
     function login(Request $request){
        $credentials = $request->only('username', 'password' , 'is_active');
        $credentials['is_active'] = 1;
        if ($token = $this->guard()->attempt($credentials  )) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
     }


     protected function respondWithToken($token)
     {
         return response()->json([
             'access_token' => $token,
             'token_type' => 'bearer',
             'expires_in' => $this->guard()->factory()->getTTL() * 60
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

     function logout(){
        auth('admin-api')::logout();

        return response()->json(['message' => 'Successfully logged out']);
     }

     function profile(){
        $user = new UserCollection($this->guard()->user());
        return response()->json($user);
     }

     function verify($token){
        $admin = Admin::where('verification_token' , $token)->firstOrFail();
        $admin->is_active = ACTIVE ;
        $admin->verified = ACTIVE ;
        $admin->verification_token = null;
        $admin->save();
        return $this->showMessage("The account has been verified succesfully ");
     }

     function resend(Admin $admin){
        if ($admin->isVerified()) {
            return $this->errorResponse('This user is already verified', 409);
        }

        retry(5, function() use ($admin) {
                Mail::to($admin)->send(new AdminCreated($admin));
            }, 100);

        return $this->showMessage('The verification email has been resend');
     }



    /**
     * show all resources
     *
     * @return mixed
     * @author Amr
     */
    function all()
    {
        return $this->admin->get();
        // return $this->showAll(Collection::make($plans));
    }

    /**
     * get the resource by id
     *
     * @param $id
     * @return mixed
     * @author Amr
     */
    function find($id)
    {
        return $this->admin->findOrFail($id);
    }

    function changeStatus(Request $request, Admin $admin, $active)
    {
        $admin->is_active = $active;
        $admin->update();
        return $plan;
    }


}

