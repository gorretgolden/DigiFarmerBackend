<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use Response;
use App\Models\Address;
use App\Models\User;
use App\Models\District;
use App\Models\VendorService;
use DB;
use App\Models\SubCategory;
/**
 * Class InsuaranceVendorServiceController
 * @package App\Http\Controllers\API
 */

class InsuaranceVendorServiceAPIController extends Controller
{


    /**
     * Display a listing of the InsuaranceVendorService.
     * GET|HEAD /insuaranceVendorServices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $insuaranceVendorServices = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Insurance')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();

        if(count($insuaranceVendorServices) == 0){

            $response = [
                'success'=>false,


                'message'=> 'No insurance vendor services have been posted'
             ];
             return response()->json($response,404);

        }else{

            $response = [
                'success'=>true,
                'data'=> [
                    'total-insurance-services'=>$insuaranceVendorServices->count(),
                    'insurance-vendor-services'=>$insuaranceVendorServices

                ],

                'message'=> 'Insuarance Vendor Services retrieved successfully'
             ];
             return response()->json($response,200);

        }



    }

    //insurance under a sub category
    public function insurance_services(Request $request,$id)
{
    $sub_category = SubCategory::find($id);

   $insurance_services  = DB::table('vendor_services')
                          ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
                          ->join('categories','categories.id','=','sub_categories.category_id')
                          ->where('categories.name','Insurance')
                           ->where('is_verified',1)
                          ->where('vendor_services.sub_category_id',$id)
                          ->orderBy('vendor_services.id','DESC')
                          ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
                          ->get();



    if ($insurance_services->count() == 0) {
        $response = [
            'success'=>true,
            'message'=> 'No insurance services have been posted under '.$sub_category->name
         ];

         return response()->json($response,404);

    }
    else{


        $response = [
            'success'=>true,
            'data'=> [
                'total-rent-services' =>$insurance_services->count(),
                'rent-services'=>$insurance_services
            ],
            'message'=> 'Rent vendor services under '.$sub_category->name.' retrieved successfully'
         ];

         return response()->json($response,200);
    }




}


 //insurance sub categories
 public function insurance_sub_categories(Request $request){

    $insurance_sub_categories = DB::table('categories')
        ->join('sub_categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Insurance')
        ->where('sub_categories.is_active',1)
        ->orderBy('sub_categories.name','ASC')
        ->select('sub_categories.id','sub_categories.name',DB::raw("CONCAT('storage/sub_categories/', sub_categories.image) AS image"),'categories.name as category')
        ->get();

        if ($insurance_sub_categories->count() == 0) {
            $response = [
                'success'=>false,
                'message'=> 'No sub categories under farmer insurances'
             ];

             return response()->json($response,404);

        }
        else{


            $response = [
                'success'=>true,
                'data'=> [
                    'total-insurance-sub-categories' =>count($insurance_sub_categories),
                    'insurance-sub-categories'=>$insurance_sub_categories
                ],
                'message'=> 'Farmer insurance sub categories retrieved successfully'
             ];

             return response()->json($response,200);
        }


}
    //home

    public function home_insurance_vendors(Request $request)
    {
        $insuaranceVendorServices = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Insurance')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->limit(5)
        ->get();

        $response = [
            'success'=>true,
            'data'=> [
                'total-insurance-services'=>$insuaranceVendorServices->count(),
                'insurance-vendor-services'=>$insuaranceVendorServices

            ],

            'message'=> 'Rent Vendor Services retrieved successfully'
         ];
         return response()->json($response,200);


    }


    public function insuarance_search(Request $request){
        $search = $request->keyword;

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,400);

        }
        $all_services = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Insurance')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();


        $insurance = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Insurance')
        ->where('is_verified',1)
        ->where('vendor_services.name', 'like', '%' . $search. '%')->orWhere('terms','like', '%' . $search.'%')
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();



        if(count($insurance) == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>count($insurance)." "."results found out of"." ".count($all_services),
                    'search-results'=>$insurance,

                ],

                'message'=> 'search results'
              ];
             return response()->json($response,200);

        }



}



 //filter products by location
 public function location_insurance(Request $request){

     if(empty($request->district_id)){
         $response = [
             'success'=>false,
             'message'=> 'Please select a district'
          ];

          return response()->json($response,400);

     }

     $district= District::find($request->district_id);

     if(empty($district)){
        $response = [
            'success'=>false,
            'message'=> 'District not found'
         ];

         return response()->json($response,404);

     }


     $insurance_services =  DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Insurance')
     ->where('is_verified',1)
     ->where('location',$district->name)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();


     $all_insurance_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Insurance')
     ->where('is_verified',1)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();


     if(count($insurance_services) == 0){

         $response = [
             'success'=>false,
             'message'=> "No results found for insurance services in"." ".$district->name
          ];

          return response()->json($response,404);

     }

     else{



         $response = [
             'success'=>true,
             'data'=>[
                 'total-results'=>count($insurance_services). " out of ".count($all_insurance_services)." insurance services" ,
                  'insurance-services'=>$insurance_services
             ],
             'message'=> "insurance services in ".$district->name. " retrieved successfully"
          ];

          return response()->json($response,200);

     }




  }


 //sorting in ascending order
 public function insurance_services_asc_sort(){

    $insurance_services =  DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Insurance')
    ->where('is_verified',1)
    ->orderBy('vendor_services.name','ASC')
    ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
    ->get();





    $response = [
        'success'=>true,
        'data'=>[
            'total-insurance-services'=>count($insurance_services),
            'insurance-services'=>$insurance_services
        ],
        'message'=> 'Insurance services ordered by name in ascending order'
     ];

     return response()->json($response,200);


 }

 public function insurance_services_desc_sort(){

    $insurance_services = DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Insurance')
    ->where('is_verified',1)
    ->orderBy('vendor_services.name','DESC')
    ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
    ->get();



    $response = [
        'success'=>true,
        'data'=>[
            'total-insurance-services'=>count($insurance_services),
            'insurance-services'=>$insurance_services
        ],
        'message'=> 'Insurance services ordered by name in descending order'
     ];

     return response()->json($response,200);


 }




       //get insurance vendors for a vendor
       public function vendor_insurance_services(Request $request)
       {

          $vendor_insurances = DB::table('vendor_services')
          ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
          ->join('categories','categories.id','=','sub_categories.category_id')
          ->where('categories.name','Insurance')
          ->where('is_verified',1)
          ->where('vendor_services.user_id',auth()->user()->id)
          ->orderBy('vendor_services.id','ASC')
          ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
          ->get();




           if ($vendor_insurances->count() == 0) {


            $response = [
                'success'=>false,
                'message'=> "You haven't posted any insurance service"
            ];

             return response()->json($response,404);

           }
           else{



               $response = [
                   'success'=>true,
                   'data'=> [
                       'total-insurance-services' =>$vendor_insurances->count(),
                       'insurance-services'=>$vendor_insurances
                   ],
                   'message'=> 'Vendor insurance services  retrieved'
                ];

                return response()->json($response,200);
           }




       }

}
