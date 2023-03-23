<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class GoogleLoginController extends Controller
{
    //login with google
    public function redirectToProvider(){
      //  dd(Socialite::driver('google')->redirect());

        return Socialite::driver('google')->redirect();

    }


    public function googleCallback(){


        try{
            Socialite::driver('google')->stateless()->user();

        }catch(RequestException $e) {
            $response = $e->getResponse()->json(); //Get error response body
          }

        //check if the user exits
        $user_exits = User::where('email',$user->email)->first();
        if($user_exits){
            Auth::login($user_exits);
            $user = User::where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
            $response = [
                'success'=>true,
                'message'=> 'You logged into your account'
             ];
             return response()->json($response);
        }

        else{

            $response = [
                'success'=>false,
                'message'=> 'An error occured'
             ];
             return response()->json($response);
        }





    }



    // public function googleCallback(){

    //     $userSocial = Socialite::driver('google')->stateless()->user();
    //     $user =  User::where(['email' => $userSocial->getEmail()])->first();
    //     if($user){
    //         Auth::login($user);
    //         $token = $user->createToken('auth_token')->plainTextToken;
    //         $response = [
    //             'success'=>true,
    //             'token'=> $token,
    //             'message'=> 'You logged into your account'
    //          ];
    //          return response()->json($response);
    //     }
    //     else{

    //         $response = [
    //             'success'=>false,
    //             'message'=> 'An error occured'
    //          ];
    //          return response()->json($response);
    //     }


    //     }
}
