<?php

namespace App\Http\Controllers;

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

            return redirect('/login');
        }
        return redirect()->to('/home');
    }
}
