<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farm;
use App\Models\Plot;
use App\Models\CropOnSale;
use App\Models\VendorService;



class SearchAPIController extends Controller
{

    public function home_search(Request $request){
        $search = $request->keyword;
        $results = [];

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,400);

        }



        //dd($search);


        $results['crops-on-sale'] = CropOnSale::where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();
        $results['vendor-services']= VendorService::where('is_verified',1)->where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->orWhere('status','on-sale')->orWhere('status','available-for-rent')->get();




        $total_results = array_sum(array_map('count', [ $results['crops-on-sale'],$results['vendor-services']]));


        if($total_results == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>$total_results,
                    'total_crops'=>count($results['crops-on-sale']),
                    'total-vendor-services'=>count($results['vendor-services']),

                    'search-results'=>$results,

                ],

                'message'=> 'search results'
              ];
             return response()->json($response,200);

        }



}

}
