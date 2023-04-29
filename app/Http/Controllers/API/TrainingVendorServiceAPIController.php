<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Carbon\Carbon;
use App\Models\User;
use App\Models\District;
use DB;
use App\Models\SubCategory;


class TrainingVendorServiceAPIController extends Controller
{



    public function index(Request $request)
    {
        $trainingVendorServices  = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Farmer Trainings')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.id as id','vendor_services.name as name','sub_categories.name as sub_category','vendor_services.starting_date','vendor_services.starting_time','vendor_services.ending_date','vendor_services.ending_time',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','status','is_verified','location')
        ->get();

        if(count($trainingVendorServices) == 0){

          $response = [
            'success'=>false,
            'message'=> 'No farmer trainings have been posted'
          ];
          return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=>[
                    'total'=>count($trainingVendorServices),
                    'trainings'=>$trainingVendorServices
                ],
                'message'=> 'Farmer training vendor services retrieved'
             ];

             return response()->json($response,200);


        }




    }


    //training sub categories
    public function training_sub_categories(Request $request){

        $training_sub_categories = DB::table('categories')
            ->join('sub_categories','categories.id','=','sub_categories.category_id')
            ->where('categories.name','Farmer Trainings')
            ->where('sub_categories.is_active',1)
            ->orderBy('sub_categories.name','ASC')
            ->select('sub_categories.id','sub_categories.name',DB::raw("CONCAT('storage/sub_categories/', sub_categories.image) AS image"),'categories.name as category')
            ->get();

            if ($training_sub_categories->count() == 0) {
                $response = [
                    'success'=>false,
                    'message'=> 'No sub categories under farmer trainings'
                 ];

                 return response()->json($response,404);

            }
            else{


                $response = [
                    'success'=>true,
                    'data'=> [
                        'total-farmer-training-sub-categories' =>count($training_sub_categories),
                        'farmer-training-sub-categories'=>$training_sub_categories
                    ],
                    'message'=> 'Farmer training sub categories retrieved successfully'
                 ];

                 return response()->json($response,200);
            }


    }

    //trainings under a subcategory
    public function trainings(Request $request,$id)
{


    $sub_category = SubCategory::find($id);

    if(empty($sub_category)){

        $response = [
            'success'=>false,
            'message'=> 'Sub category under farmer trainings not found'
         ];

         return response()->json($response,404);

    }

   $trainings  = DB::table('vendor_services')
                          ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
                          ->join('categories','categories.id','=','sub_categories.category_id')
                          ->where('categories.name','Farmer Trainings')
                          ->where('is_verified',1)
                          ->where('vendor_services.sub_category_id',$id)
                          ->orderBy('vendor_services.id','DESC')
                          ->select('vendor_services.id as id','vendor_services.name as name','sub_categories.name as sub_category','vendor_services.starting_date','vendor_services.starting_time','vendor_services.ending_date','vendor_services.ending_time','vendor_services.image','description','price_unit','charge','status','is_verified','location')
                          ->get();



    if ($trainings->count() == 0) {
        $response = [
            'success'=>true,
            'message'=> 'No farmer trainings have been posted under '.$sub_category->name
         ];

         return response()->json($response,404);

    }
    else{


        $response = [
            'success'=>true,
            'data'=> [
                'training-sub-category'=>$sub_category->name,
                'total-trainings' =>$trainings->count(),
                'trainings'=>$trainings
            ],
            'message'=> 'Training vendor services under '.$sub_category->name.' retrieved successfully'
         ];

         return response()->json($response,200);
    }




}



      //training vendor services for a single vendor
    public function vendorTrainings(Request $request)
    {

        $vendor_trainings  = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Farmer Trainings')
        ->where('is_verified',1)
        ->where('vendor_services.user_id',auth()->user()->id)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.id as id','vendor_services.name as name','sub_categories.name as sub_category','vendor_services.starting_date','vendor_services.starting_time','vendor_services.ending_date','vendor_services.ending_time',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','status','is_verified','location')
        ->get();

        if($vendor_trainings->count()==0){
            $response = [
                'success'=>false,

                'message'=> "You haven't posted any training services"
             ];
             return response()->json($response,200);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-training-services'=>$vendor_trainings->count(),
                    'training-vendor-services'=>$vendor_trainings

                ],

                'message'=> 'Vendor training services retrieved successfully'
             ];
             return response()->json($response,200);

        }


    }


    public function training_search(Request $request){
        $search = $request->keyword;

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,400);

        }

        $all_trainings  = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Farmer Trainings')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.id as id','vendor_services.name as name','sub_categories.name as sub_category','vendor_services.starting_date','vendor_services.starting_time','vendor_services.ending_date','vendor_services.ending_time',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','status','is_verified','location')
        ->get();

        $trainings  = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Farmer Trainings')
        ->where('is_verified',1)
        ->where('vendor_services.name', 'like', '%' . $search. '%')
        ->orWhere('description','like', '%' . $search.'%')
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.id as id','vendor_services.name as name','sub_categories.name as sub_category','vendor_services.starting_date','vendor_services.starting_time','vendor_services.ending_date','vendor_services.ending_time','vendor_services.image','description','price_unit','charge','status','is_verified','location')
        ->get();


        if(count($trainings) == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>count($trainings)." "."results found out of"." ".count($all_trainings),
                    'search-results'=>$trainings,

                ],

                'message'=> 'search results'
              ];
             return response()->json($response,200);

        }



}



//filter by price range
public function charge_range(Request $request){



    if(empty($request->min_charge) || empty($request->max_charge)){

     $response = [
         'success'=>false,
         'message'=> 'Charge range required'
      ];

      return response()->json($response,400);

    }else{


     $training_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Farmer Trainings')
     ->where('is_verified',1)
     ->whereBetween('charge', [$request->min_charge, $request->max_charge])
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.id as id','vendor_services.name as name','sub_categories.name as sub_category','vendor_services.starting_date','vendor_services.starting_time','vendor_services.ending_date','vendor_services.ending_time',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','status','is_verified','location')
     ->get();


     if(count($training_services)==0){
        $response = [
            'success'=>false,
            'message'=> "No training services found between"." "."UGX ".$request->min_charge ." and "."UGX ". $request->max_charge
         ];

         return response()->json($response,404);

     }else{

        $response = [
            'success'=>true,
            'data'=>[
                'total-results'=>count($training_services),
                'training-services'=>$training_services
            ],
            'message'=> "Training services between "."UGX ".$request->min_charge ." and "."UGX ". $request->max_charge." "."retrieved successfully"
         ];

         return response()->json($response,200);
     }


    }




 }

 //filter products by location
 public function location_training_services(Request $request){

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


     $training_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Farmer Trainings')
     ->where('is_verified',1)
     ->where('location',$district->name)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.id as id','vendor_services.name as name','sub_categories.name as sub_category','vendor_services.starting_date','vendor_services.starting_time','vendor_services.ending_date','vendor_services.ending_time',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','status','is_verified','location')
     ->get();

     $all_training_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Farmer Trainings')
     ->where('is_verified',1)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.id as id','vendor_services.name as name','sub_categories.name as sub_category','vendor_services.starting_date','vendor_services.starting_time','vendor_services.ending_date','vendor_services.ending_time',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','status','is_verified','location')
     ->get();



     if(count($training_services) == 0){

         $response = [
             'success'=>false,
             'message'=> "No results found for training services in"." ".$district->name
          ];

          return response()->json($response,404);

     }

     else{



         $response = [
             'success'=>true,
             'data'=>[
                 'total-results'=>count($training_services). " out of ".count($all_training_services)." training services" ,
                  'training-services'=>$training_services
             ],
             'message'=> "Training services in ".$district->name. " retrieved successfully"
          ];

          return response()->json($response,200);

     }




  }


 //sorting in ascending order

 public function training_services_asc_sort(){

    $training_services = DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Farmer Trainings')
    ->where('is_verified',1)
    ->orderBy('vendor_services.name','ASC')
    ->select('vendor_services.id as id','vendor_services.name as name','sub_categories.name as sub_category','vendor_services.starting_date','vendor_services.starting_time','vendor_services.ending_date','vendor_services.ending_time',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','status','is_verified','location')
    ->get();




    $response = [
        'success'=>true,
        'data'=>[
            'total-training-services'=>count($training_services),
            'training-services'=>$training_services
        ],
        'message'=> 'Training services ordered by name in ascending order'
     ];

     return response()->json($response,200);


 }

 public function training_services_desc_sort(){

    $training_services = DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Farmer Trainings')
    ->where('is_verified',1)
    ->orderBy('vendor_services.name','DESC')
    ->select('vendor_services.id as id','vendor_services.name as name','sub_categories.name as sub_category','vendor_services.starting_date','vendor_services.starting_time','vendor_services.ending_date','vendor_services.ending_time',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"),'description','price_unit','charge','status','is_verified','location')
    ->get();


    $response = [
        'success'=>true,
        'data'=>[
            'total-training-services'=>count($training_services),
            'training-services'=>$training_services
        ],
        'message'=> 'training services ordered by name in descending order'
     ];

     return response()->json($response,200);


 }






    }







