<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function adminProfile(Request $request){
        $admin_details = auth()->user();

        return view('admin-profile.index',compact('admin_details'));
    }
}
