<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\SubCategory;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\File;
use App\Models\District;
use DB;

/**
 * Class SellerProductController
 * @package App\Http\Controllers\API
 */

class SellerProductAPIController extends Controller
{


    public function index(){

        $farm_equipments = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Farm Equipments')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->paginate(10);;

        if($farm_equipments->count() == 0){

            $response = [
                'success'=>false,

                'message'=> 'No farm equipments have been posted yet'
             ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-farm-equipments'=>$farm_equipments->count(),
                    'farm-equipments'=>$farm_equipments

                ],

                'message'=> 'All farm equipments retrieved successfully'
             ];
             return response()->json($response,200);
        }


    }


    //get farm equipments under a sub category

public function farm_equipments(Request $request,$id)
{
    $sub_category = SubCategory::find($id);



    if (empty($sub_category)) {
        $response = [
            'success'=>false,
            'message'=> 'Sub category not found'
         ];

         return response()->json($response,404);

    }

    $farm_equipments  = DB::table('vendor_services')
                          ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
                          ->join('categories','categories.id','=','sub_categories.category_id')
                          ->where('categories.name','Farm Equipments')
                          ->where('vendor_services.status','on-sale')->where('is_verified',1)
                          ->where('vendor_services.sub_category_id',$id)
                          ->orderBy('vendor_services.id','DESC')
                          ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
                          ->paginate(10);




    if ($farm_equipments->count() == 0) {
        $response = [
            'success'=>true,
            'message'=> 'No  farm equipments have been posted under '.$sub_category->name
         ];

         return response()->json($response,404);

    }
    else{


        $response = [
            'success'=>true,
            'data'=> [
                'total-farm-equipments' =>$farm_equipments->count(),
                'farm-equipments'=>$farm_equipments
            ],
            'message'=> 'Farm equipments under '.$sub_category->name.' retrieved successfully'
         ];

         return response()->json($response,200);
    }




}

//farm equipment sub categories
public function farm_equipments_sub_categories(Request $request){




    $farm_equipment_sub_categories = DB::table('categories')
        ->join('sub_categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Farm Equipments')
        ->where('sub_categories.is_active',1)
        ->orderBy('sub_categories.name','ASC')
        ->select('sub_categories.*',DB::raw("CONCAT('storage/sub_categories/', sub_categories.image) AS image"),'categories.name as category')
        ->get();

        if ($farm_equipment_sub_categories->count() == 0) {
            $response = [
                'success'=>false,
                'message'=> 'No sub categories for farm equipments'
             ];

             return response()->json($response,404);

        }
        else{


            $response = [
                'success'=>true,
                'data'=> [
                    'total-farm-equipments' =>count($farm_equipment_sub_categories),
                    'farm-equipments'=>$farm_equipment_sub_categories
                ],
                'message'=> 'Farm equipment subcategories retrieved successfully'
             ];

             return response()->json($response,200);
        }


}




     //get vendor seller products
     public function vendor_farm_equipments(Request $request)
     {

        $vendor_farm_equipments = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Farm Equipments')
        ->where('is_verified',1)
        ->where('vendor_services.user_id',auth()->user()->id)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();



         if ($vendor_farm_equipments->count() == 0) {
            $response = [
                'success'=>false,
                'message'=> "You haven't posted any farm equipment"
             ];

             return response()->json($response,404);

         }
         else{


             $response = [
                 'success'=>true,
                 'data'=> [
                     'total-farm-equipments' =>count($vendor_farm_equipments),
                     'farm-equipments'=>$vendor_farm_equipments
                 ],
                 'message'=> 'Vendor farm equipments'
              ];

              return response()->json($response,200);
         }




     }



    public function product_search(Request $request){
        $search = $request->keyword;

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,200);

        }

        $total_products =  DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Farm Equipments')
        ->where('vendor_services.status','on-sale')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();


        $products = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Farm Equipments')
        ->where('vendor_services.status','on-sale')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->where('vendor_services.name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->paginate(10);;



        if(count($products) == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>count($products)." "."results found out of"." ".count($total_products),
                    'search-results'=>$products,

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

             $seller_products = DB::table('vendor_services')
             ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
             ->join('categories','categories.id','=','sub_categories.category_id')
             ->where('categories.name','Farm Equipments')
             ->where('vendor_services.status','on-sale')->where('is_verified',1)
             ->whereBetween('price', [$request->min_price, $request->max_price])
             ->orderBy('vendor_services.id','DESC')
             ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
             ->paginate(10);;



             if(count($seller_products)==0){
                $response = [
                    'success'=>false,
                    'message'=> "No Farm equipments found between"." "."UGX ".$request->min_price ." and "."UGX ". $request->max_price
                 ];

                 return response()->json($response,404);

             }else{
                $response = [
                    'success'=>true,
                    'data'=>[
                        'total-results'=>count($seller_products),
                        'seller-products'=>$seller_products
                    ],
                    'message'=> "Farm equipemnts between "."UGX ".$request->min_price ." and "."UGX ". $request->max_price." "."retrieved successfully"
                 ];

                 return response()->json($response,200);
             }


            }




         }

         //filter products by location
         public function location_seller_products(Request $request){

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


             $seller_products = DB::table('vendor_services')
             ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
             ->join('categories','categories.id','=','sub_categories.category_id')
             ->where('categories.name','Farm Equipments')
             ->where('vendor_services.status','on-sale')->where('is_verified',1)
             ->where('location',$district->name)
             ->orderBy('vendor_services.id','DESC')
             ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
             ->paginate(10);



             $all_seller_products =  DB::table('vendor_services')
             ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
             ->join('categories','categories.id','=','sub_categories.category_id')
             ->where('categories.name','Farm Equipments')
             ->where('vendor_services.status','on-sale')->where('is_verified',1)
             ->orderBy('vendor_services.id','DESC')
             ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
             ->get();

             if(count($seller_products) == 0){

                 $response = [
                     'success'=>false,
                     'message'=> "No results found for farm equipments in"." ".$district->name
                  ];

                  return response()->json($response,404);

             }

             else{

               //  dd($seller_products);

                 $response = [
                     'success'=>true,
                     'data'=>[
                         'total-results'=>count($seller_products). " out of ".count($all_seller_products)." farm equipments in ".$district->name ,
                          'farm-equipments'=>$seller_products
                     ],
                     'message'=> 'Farm equipments retrieved successfully'
                  ];

                  return response()->json($response,200);

             }




          }


         //sorting in ascending order


         public function seller_producting_asc_sort(){

            $seller_products = DB::table('vendor_services')
            ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
            ->join('categories','categories.id','=','sub_categories.category_id')
            ->where('categories.name','Farm Equipments')
            ->where('vendor_services.status','on-sale')->where('is_verified',1)
            ->orderBy('vendor_services.id','ASC')
            ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
            ->paginate(10);

            $response = [
                'success'=>true,
                'data'=>[
                    'total-seller-products'=>count($seller_products),
                    'seller-products'=>$seller_products
                ],
                'message'=> 'Farm equipments ordered by name in ascending order'
             ];

             return response()->json($response,200);


         }

         public function seller_producting_desc_sort(){

            $seller_products = DB::table('vendor_services')
            ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
            ->join('categories','categories.id','=','sub_categories.category_id')
            ->where('categories.name','Farm Equipments')
            ->where('vendor_services.status','on-sale')->where('is_verified',1)
            ->orderBy('vendor_services.id','DESC')
            ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
            ->paginate(10);


            $response = [
                'success'=>true,
                'data'=>[
                    'total-seller-products'=>count($seller_products),
                    'seller-products'=>$seller_products
                ],
                'message'=> 'Farm equipments ordered by name in descending order'
             ];

             return response()->json($response,200);


         }







}
