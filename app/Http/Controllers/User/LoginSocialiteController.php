<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;

class LoginSocialiteController extends Controller
{
     /**
     * Redirect the user to the Socialite authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        // return "bv";
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Socialite.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        // $user->token;
    }


    

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $finduser = User::where('email',$googleUser->email)->first();
            if($finduser){
                Auth::login($finduser);
                //  return redirect('/home');
            }else{
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'username'=> $googleUser->name
                ]);
  
                Auth::login($newUser);
                return response()->json(['message' => 'User Logined']);
                // return $this->respondWithToken($newUser);
            }
            
        } 
        catch (Exception $e) {
            return response()->json(['message' => 'login error']);
        }
    }
}
