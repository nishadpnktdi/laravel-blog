<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NotifyAdminUserCreation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
Use App\Events\NewUserRegisteredEvent;
use App\Events\NewUserRegisteredUsingSocial;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {
      
            $user = Socialite::driver('facebook')->user();
       
            $finduser = User::where('facebook_id', $user->id)
                            ->orWhere('email', $user->email)->first();
       
            if($finduser){

                if($finduser->email == $user->email)
                {
                    $finduser->update([
                        'facebook_id'=> $user->id,
                    ]);
                }
       
                Auth::login($finduser);
      
                return redirect()->intended('dashboard');
       
            }else{

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id'=> $user->id,
                    'password' => encrypt('bla321'),
                ]);

                event(new NewUserRegisteredUsingSocial($user));
                
                Auth::login($newUser);
      
                return redirect()->intended('dashboard');
            }

      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
