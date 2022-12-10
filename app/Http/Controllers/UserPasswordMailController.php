<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserPassword;

class UserPasswordMailController extends Controller
{

    public function resetPassword(){
        Mail::to('nabatanzigorret143@gmail.com')->send(new UserPassword());
        return view('home');

    }
}
