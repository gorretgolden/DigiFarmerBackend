<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Crop;
use App\Models\Farm;
use App\Models\AnimalCategory;
use App\Models\CropOnSale;
use App\Models\CropOrder;
use DB;

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
        $total_farmers = User::where('user_type','=','farmer')->count();
        $total_vendors = User::where('is_vendor',1)->count();
        $total_users = User::all()->count();
        $total_farms = Farm::all()->count();
        $total_animals = AnimalCategory::all()->count();
        $total_crops = Crop::all()->count();
        $total_crops_on_sale = CropOnSale::all()->count();
        $total_crop_orders = CropOrder::all()->count();

        //chart
        // $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
        //             ->whereYear('created_at', date('Y'))
        //             ->groupBy(DB::raw("Month(created_at)"))
        //             ->pluck('count', 'month_name');

        // $labels = $users->keys();
        // $data = $users->values();

        return view('home',compact('total_farmers','total_vendors','total_users','total_farms','total_crops','total_crops_on_sale','total_crop_orders','total_animals'));
    }

    public function admin(){
        return view('admin-restriction');
    }
}
