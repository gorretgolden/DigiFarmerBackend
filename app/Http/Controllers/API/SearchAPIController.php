<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farm;
use App\Models\Plot;
use App\Models\CropOnSale;
use App\Models\RentVendorService;
use App\Models\InsuaranceVendorService;
use App\Models\TrainingVendorService;
use App\Models\AgronomistVendorService;
use App\Models\Veterinary;
use App\Models\AnimalFeed;
use App\Models\SellerProduct;


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
             return response()->json($response,200);

        }



        //dd($search);


        $results['crops-on-sale'] = CropOnSale::where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();
        $results['rent-services']= RentVendorService::with('images')->where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();
        $results['insurance-services'] = InsuaranceVendorService::where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();
        $results['training-services'] = TrainingVendorService::where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();
        $results['agronomist-services'] = AgronomistVendorService::where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();
        $results['vet-services'] = Veterinary::where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();
        $results['animal-feeds'] = AnimalFeed::where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();
        $results['farm-products'] = SellerProduct::where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();



        $total_results = array_sum(array_map('count', [ $results['crops-on-sale'],$results['rent-services'],$results['insurance-services'],$results['training-services'] ,$results['agronomist-services'],$results['vet-services'], $results['animal-feeds'], $results['farm-products'] ]));


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
                    'total-rent-services'=>count($results['rent-services']),
                    'total-insurances'=>count($results['insurance-services']),
                    'total-trainings'=>count($results['training-services']),
                    'total-agronomist-services' => count($results['agronomist-services']),
                    'total-vet-services' => count($results['vet-services']),
                    'total-animal-feeds'=> count($results['animal-feeds']),
                    'total-farm-products'=>count($results['farm-products']),
                    'search-results'=>$results,

                ],

                'message'=> 'search results'
              ];
             return response()->json($response,200);

        }



}

}
