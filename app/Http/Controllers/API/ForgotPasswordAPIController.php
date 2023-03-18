<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Flash;
use DB;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Str;


class ForgotPasswordAPIController extends Controller
{
    public function forgotPassword(Request $request) {
        $credentials = request()->validate(['email' => 'required|email']);
        $existing_email = User::where('email',request()->email)->first();

        if(!$existing_email){
          $response = [
            'message'=> 'Email address doesnt exist'
          ];

          return response()->json($response,404);
        }

        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
          ]);

        Mail::send('Email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });


        return response()->json(["message" => 'Reset password link has been  sent to your email address']);
    }


    public function resetPassword() {
        dd('fcff');
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);


        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
            });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json(["msg" => "Invalid token provided"], 400);
        }
        Flash::success('Password has been successfully changed');
        return redirect(route('home'));

        // return response()->json(["msg" => "Password has been successfully changed"]);
    }
}
