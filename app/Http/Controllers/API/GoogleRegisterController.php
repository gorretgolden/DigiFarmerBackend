<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class GoogleRegisterController extends Controller
{
    //login with google
    public function redirectToProvider(){
        return Socialite::driver('google')->redirect();

    }

    //handle callback

    public function googleCallback(){

        try{
            $user =Socialite::driver('google')->user();

        }catch(\Excepetion $e){
            return redirect('/login');

        }

        //check if the user exits
        $user_exits = User::where('email',$user->email)->first();
        if($user_exits){
            Auth::login($user_exits,true);
        }
        //else create a new user
        else{

            $newUser = User::create(
                [
                    'first_name'=>$user['given_name'],
                    'last_name'=>$user['family_name'],
                    'email'=>$user->email,
                    'email_verified_at'=> now(),
                    'google_id'=>$user->id,
                    'image'=>$user->avatar,


                ]
                );
            $newUser->assignRole('user');
            Auth::login($newUser,false);
        }
        return redirect()->to('/home');
    }
}
