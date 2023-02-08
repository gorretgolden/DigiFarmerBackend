<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications()->limit(5)->get();
        return view('notifications',compact('notifications'));

    }
}
