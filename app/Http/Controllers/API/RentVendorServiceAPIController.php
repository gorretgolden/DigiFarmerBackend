<?php

namespace App\Http\Controllers\API;


use App\Models\VendorService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Address;
use App\Models\User;
use App\Models\District;
use App\Model\SubCategory;
use App\Notifications\NewRentServiceNotification;
use DB;



/**
 * Class RentVendorServiceController
 * @package App\Http\Controllers\API
 */

class RentVendorServiceAPIController extends Controller
{


    //get all rent vendor services
    public function index(Request $request)
    {

        $rentVendorServices = VendorService::where('status','available-for-rent')->where('is_verified',1)->latest()->get(
            ['id','name','image','description','price_unit','charge','charge_frequency','stock_amount','status','is_verified','created_at']
        );
        $response = [
            'success'=>true,
            'data'=> [
                'total-rent-services'=>$rentVendorServices->count(),
                'rent-vendor-services'=>$rentVendorServices

            ],

            'message'=> 'All rent vendor Services retrieved successfully'
         ];
         return response()->json($response,200);


    }

    //home rent vendor services
    public function home_rent_vendors(Request $request)
    {

        $rentVendorServices = DB::table('vendor_services')
                     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
                     ->join('categories','categories.id','=','sub_categories.category_id')
                     ->where('categories.name','Rent')
                     ->where('vendor_services.status','available-for-rent')->where('is_verified',1)
                     ->orderBy('vendor_services.id','DESC')
                    ->select('vendor_services.id','vendor_services.name',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','charge_frequency','stock_amount','status','is_verified','location')
                    ->limit(5)->get();



        $response = [
            'success'=>true,
            'data'=> [
                'total-rent-services'=>$rentVendorServices->count(),
                'rent-vendor-services'=>$rentVendorServices

            ],

            'message'=> 'Rent Vendor Services retrieved successfully'
         ];
         return response()->json($response,200);


    }


//get rent services under a sub category

public function rent_services(Request $request,$id)
{
    $sub_category = SubCategory::find($id);

   $rent_vendor_services  = DB::table('vendor_services')
                          ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
                          ->join('categories','categories.id','=','sub_categories.category_id')
                          ->where('categories.name','Rent')
                          ->where('vendor_services.status','available-for-rent')->where('is_verified',1)
                          ->where('vendor_services.sub_category_id',$id)
                          ->orderBy('vendor_services.id','DESC')
                          ->select('vendor_services.id','vendor_services.name',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','charge_frequency','stock_amount','status','is_verified','location')
                          ->get();



    if ($rent_vendor_services->count() == 0) {
        $response = [
            'success'=>true,
            'message'=> 'No rent services have been posted under '.$sub_category->name
         ];

         return response()->json($response,404);

    }
    else{


        $response = [
            'success'=>true,
            'data'=> [
                'total-rent-services' =>$rent_vendor_services->count(),
                'rent-services'=>$rent_vendor_services
            ],
            'message'=> 'Rent vendor services under '.$sub_category->name.' retrieved successfully'
         ];

         return response()->json($response,200);
    }




}


//get rent sub categories

public function rent_sub_categories(Request $request){

    $rent_sub_categories =  DB::table('categories')
        ->join('sub_categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Rent')
        ->where('sub_categories.is_active',1)
        ->orderBy('sub_categories.name','ASC')
        ->select('sub_categories.id','sub_categories.name',DB::raw("CONCAT('storage/sub_categories/', sub_categories.image) AS image"),'categories.name as category')
        ->get();

        if ($rent_sub_categories->count() == 0) {
            $response = [
                'success'=>false,
                'message'=> 'No sub categories under rent vendor services'
             ];

             return response()->json($response,404);

        }
        else{


            $response = [
                'success'=>true,
                'data'=> [
                    'total-rent-sub-categories' =>count($rent_sub_categories),
                    'rent-sub-categories'=>$rent_sub_categories
                ],
                'message'=> 'Rent subcategories retrieved successfully'
             ];

             return response()->json($response,200);
        }


}





    //get vendor rent services
    public function vendorRentService(Request $request)
    {

       $rent_vendor_services  = DB::table('vendor_services')
                              ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
                              ->join('categories','categories.id','=','sub_categories.category_id')
                              ->where('categories.name','Rent')
                              ->where('is_verified',1)
                              ->where('vendor_services.user_id',auth()->user()->id)
                              ->orderBy('vendor_services.id','DESC')
                              ->select('vendor_services.id','vendor_services.name',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','charge_frequency','stock_amount','status','is_verified','location')
                              ->get();




        if ($rent_vendor_services->count() == 0) {
            $response = [
                'success'=>true,
                'message'=> 'You havent posted any rent services'
             ];

             return response()->json($response,404);

        }
        else{


            $response = [
                'success'=>true,
                'data'=> [
                    'total-rent-services' =>$rent_vendor_services->count(),
                    'rent-services'=>$rent_vendor_services
                ],
                'message'=> 'Vendor rent services retrieved'
             ];

             return response()->json($response,200);
        }




    }



    public function rent_search(Request $request){
        $search = $request->keyword;

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,200);

        }



        $all_rent   = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Rent')
        ->where('vendor_services.status','available-for-rent')->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.id','vendor_services.name',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','charge_frequency','stock_amount','status','is_verified','location')
        ->get();


        $rent = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Rent')
        ->where('vendor_services.status','available-for-rent')->where('is_verified',1)
        ->where('vendor_services.name', 'like', '%' . $search. '%')
        ->orWhere('description','like', '%' . $search.'%')
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.id','vendor_services.name',DB::raw("CONCAT('storage/sub_categories/', sub_categories.image) AS image"),'description','price_unit','charge','charge_frequency','stock_amount','status','is_verified','location')
        ->get();



        if(count($rent) == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>count($rent)." "."results found out of"." ".count($all_rent),
                    'search-results'=>$rent,

                ],

                'message'=> 'search results'
              ];
             return response()->json($response,200);

        }



}


 //filter by price range
 public function price_range(Request $request){



    if(empty($request->min_price) || empty($request->max_price)){

     $response = [
         'success'=>false,
         'message'=> 'Price range required'
      ];

      return response()->json($response,400);

    }else{


     $rent_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Rent')
     ->where('vendor_services.status','available-for-rent')->where('is_verified',1)
     ->whereBetween('charge', [$request->min_price, $request->max_price])
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.id','vendor_services.name',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','charge_frequency','stock_amount','status','is_verified','location')
     ->get();


     if(count($rent_services)==0){
        $response = [
            'success'=>false,
            'message'=> "No items for rent found between"." "."UGX ".$request->min_price ." and "."UGX ". $request->max_price
         ];

         return response()->json($response,404);

     }else{

        $response = [
            'success'=>true,
            'data'=>[
                'total-results'=>count($rent_services),
                'rent-services'=>$rent_services
            ],
            'message'=> "Rent items between "."UGX ".$request->min_price ." and "."UGX ". $request->max_price." "."retrieved successfully"
         ];

         return response()->json($response,200);
     }


    }




 }

 //filter products by location
 public function location_rent_services(Request $request){

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


     $rent_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Rent')
     ->where('vendor_services.status','available-for-rent')->where('is_verified',1)
     ->where('location',$district->name)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.id','vendor_services.name',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','charge_frequency','stock_amount','status','is_verified','location')
     ->get();



     $all_rent_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Rent')
     ->where('vendor_services.status','available-for-rent')->where('is_verified',1)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.id','vendor_services.name',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','charge_frequency','stock_amount','status','is_verified','location')
     ->get();





     if(count($rent_services) == 0){

         $response = [
             'success'=>false,
             'message'=> "No results found for rent items in"." ".$district->name
          ];

          return response()->json($response,404);

     }

     else{



         $response = [
             'success'=>true,
             'data'=>[
                 'total-results'=>count($rent_services). " out of ".count($all_rent_services)." rent items" ,
                  'rent-services'=>$rent_services
             ],
             'message'=> "Rent items in ".$district->name. " retrieved successfully"
          ];

          return response()->json($response,200);

     }




  }




  //sorting in ascending order


  public function rent_services_asc_sort(){

    $rent_services = DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Rent')
    ->where('vendor_services.status','available-for-rent')->where('is_verified',1)
    ->orderBy('vendor_services.name','ASC')
    ->select('vendor_services.id','vendor_services.name',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','charge_frequency','stock_amount','status','is_verified','location')
    ->get();




    $response = [
        'success'=>true,
        'data'=>[
            'total-rent-services'=>count($rent_services),
            'rent-services'=>$rent_services
        ],
        'message'=> 'Rent services ordered by name in ascending order'
     ];

     return response()->json($response,200);


 }

 public function rent_services_desc_sort(){

    $rent_services = DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Rent')
    ->where('vendor_services.status','available-for-rent')->where('is_verified',1)
    ->orderBy('vendor_services.name','DESC')
    ->select('vendor_services.id','vendor_services.name',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','charge_frequency','stock_amount','status','is_verified','location')
    ->get();


    $response = [
        'success'=>true,
        'data'=>[
            'total-rent-services'=>count($rent_services),
            'rent-services'=>$rent_services
        ],
        'message'=> 'Rent items ordered by name in descending order'
     ];

     return response()->json($response,200);


 }









    public function rent_items(Request $request,$id)
    {



      $rent_sub_category = RentVendorSubCategory::find($id);

      if(empty($rent_sub_category)){

        $response = [
            'success'=>false,
            'message'=> 'Rent sub category not found'
         ];

         return response()->json($response,404);

      }

      if(count($rent_sub_category->rent_vendor_services) == 0){

        $response = [
            'success'=>false,
            'message'=> 'No rent services found for '.$rent_sub_category->name
         ];

         return response()->json($response,404);

      }

      $response = [
        'success'=>true,
        'data'=>[

            'category'=>$rent_sub_category->rent_category->name,
            'sub-category'=>$rent_sub_category->name,
            'rent-services'=>$rent_sub_category->rent_vendor_services
        ]
        ,


        'message'=> 'Successfully retrieved rent services under '.$rent_sub_category->name
     ];

     return response()->json($response,200);
    }



}
