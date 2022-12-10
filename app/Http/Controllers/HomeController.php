<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Crop;
use App\Models\Farm;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_farmers = User::where('user_type_id','=',2)->count();
        $total_sellers = User::where('user_type_id','=',4)->count();
        $total_farms = Farm::all()->count();
        $total_crops = Crop::all()->count();

        return view('home',compact('total_farmers','total_sellers','total_farms','total_crops'));
    }

    public function admin(){
        return view('admin-restriction');
    }
}
