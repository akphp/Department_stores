<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Interfaces\AdminInterface;
use App\Mail\AdminCreated;
use App\Mail\UserCreated;
use App\Models\Admin;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;

    private $adminRepository;

    /**
     * PlanController constructor.
     * @param PlanInterface $planeRepository
     */

    public function __construct(AdminInterface $adminRepository)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verify', 'resend']]);
        $this->adminRepository = $adminRepository;
    }



    public function register(Request $request)
    {
        return  $this->adminRepository->register($request);
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
        return $this->adminRepository->login($request);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->adminRepository->profile();
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return $this->adminRepository->logout();
    }


    public function verify($token)
    {
        return $this->adminRepository->verify($token);
    }


    public function resend(Admin $admin)
    {
        return $this->adminRepository->resend($admin);
    }
}
