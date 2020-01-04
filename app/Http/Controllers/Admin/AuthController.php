<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
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
     * AuthController constructor.
     * @param AdminInterface $adminRepository
     */

    public function __construct(AdminInterface $adminRepository)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verify', 'resend']]);
        $this->adminRepository = $adminRepository;
    }



    public function register(AdminRequest $request)
    {
        return  $this->adminRepository->register($request);
    }


    public function login(Request $request)
    {
        return $this->adminRepository->login($request);
    }

    public function me()
    {
        return $this->adminRepository->profile();
    }

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
