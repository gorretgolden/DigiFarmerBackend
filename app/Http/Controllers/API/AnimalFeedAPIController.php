<?php

namespace App\Http\Controllers\API;

use App\Repositories\AnimalFeedRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\VendorService;
use App\Models\User;
use App\Models\Address;
use App\Models\District;
use App\Models\AnimalCategory;
use App\Notifications\NewAnimalFeedNotification;
use DB;

/**
 * Class AnimalFeedController
 * @package App\Http\Controllers\API
 */

class AnimalFeedAPIController extends AppBaseController
{
    /** @var  AnimalFeedRepository */
    private $animalFeedRepository;

    public function __construct(AnimalFeedRepository $animalFeedRepo)
    {
        $this->animalFeedRepository = $animalFeedRepo;
    }

    /**
     * Display a listing of the AnimalFeed.
     * GET|HEAD /animalFeeds
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {


             $animalFeeds = DB::table('vendor_services')
                                  ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
                                  ->join('categories','categories.id','=','sub_categories.category_id')
                                  ->where('categories.name','Animal Feeds')
                                  ->where('vendor_services.status','on-sale')
                                  ->where('is_verified',1)
                                  ->orderBy('vendor_services.id','DESC')
                                  ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
                                  ->get();

        $response = [
            'success'=>true,
            'data'=> [
                'total-animal-feeds'=>count($animalFeeds),
                'animal-feeds'=>$animalFeeds
            ],
            'message'=> 'Animal Feeds retrieved successfully'
         ];
         return response()->json($response,200);

    }

    public function animal_feed_sub_categories(Request $request){

        $animal_feed_sub_categories =  DB::table('categories')
            ->join('sub_categories','categories.id','=','sub_categories.category_id')
            ->where('categories.name','Animal Feeds')
            ->where('sub_categories.is_active',1)
            ->orderBy('sub_categories.name','ASC')
            ->select('sub_categories.id','sub_categories.name',DB::raw("CONCAT('storage/sub_categories/', sub_categories.image) AS image"),'categories.name as category')
            ->get();

            if ($animal_feed_sub_categories->count() == 0) {
                $response = [
                    'success'=>false,
                    'message'=> 'No sub categories under animal feeds'
                 ];

                 return response()->json($response,404);

            }
            else{


                $response = [
                    'success'=>true,
                    'data'=> [
                        'total-animal-feed-sub-categories' =>count($animal_feed_sub_categories),
                        'animal-feed-sub-categories'=>$animal_feed_sub_categories
                    ],
                    'message'=> 'Animal feed subcategories retrieved successfully'
                 ];

                 return response()->json($response,200);
            }


    }






    //get animal feeds for a vendor
    public function vendorAnimalFeeds(Request $request)
    {


       $vendor_animal_feeds = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Animal Feeds')
        ->where('is_verified',1)
        ->where('user_id',auth()->user()->id)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->limit(5)
        ->get();



        if ($vendor_animal_feeds->count() == 0) {

            $response = [
                'success'=>true,
                'message'=> 'You havent posted any animal feeds'
             ];

             return response()->json($response,404);

        }
        else{



            $response = [
                'success'=>true,
                'data'=> [
                    'total-animal-feeds' =>count($vendor_animal_feeds),
                    'animal-feeds'=>$vendor_animal_feeds
                ],
                'message'=> 'Vendor animal feeds retrieved'
             ];

             return response()->json($response,200);
        }




    }

    public function home_animal_feeds(Request $request)
    {
        $animal_feeds = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Animal Feeds')
        ->where('vendor_services.status','on-sale')->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->limit(5)
        ->get();

        $response = [
            'success'=>true,
            'data'=> [
                'total-feeds'=>$animal_feeds->count(),
                'feeds'=>$animal_feeds

            ],

            'message'=> 'Animal feeds retrieved successfully'
         ];
         return response()->json($response,200);


    }


    public function animal_feed_search(Request $request){
        $search = $request->keyword;

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,400);

        }
        $total_feeds = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Animal Feeds')
        ->where('vendor_services.status','on-sale')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();



        $animal_feeds = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Animal Feeds')
        ->where('vendor_services.status','on-sale')
        ->where('is_verified',1)
        ->where('vendor_services.name', 'like', '%' . $search. '%')
        ->orWhere('description','like', '%' . $search.'%')
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();




        if(count($animal_feeds) == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>count($animal_feeds)." "."results found out of"." ".count($total_feeds),
                    'search-results'=>$animal_feeds,

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


     $animal_feeds = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Animal Feeds')
     ->where('vendor_services.status','on-sale')
     ->where('is_verified',1)
     ->whereBetween('price', [$request->min_price, $request->max_price])
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();



     if(count($animal_feeds)==0){
        $response = [
            'success'=>false,
            'message'=> "No Animal feeds found between"." "."UGX ".$request->min_price ." and "."UGX ". $request->max_price
         ];

         return response()->json($response,404);

     }else{

        $response = [
            'success'=>true,
            'data'=>[
                'total-results'=>count($animal_feeds),
                'animal-feeds'=>$animal_feeds
            ],
            'message'=> "Animal feeds between "."UGX ".$request->min_price ." and "."UGX ". $request->max_price." "."retrieved successfully"
         ];

         return response()->json($response,200);
     }


    }




 }

 //filter products by location
 public function location_animal_feeds(Request $request){

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


     $animal_feeds = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Animal Feeds')
     ->where('vendor_services.status','on-sale')
     ->where('is_verified',1)
     ->where('location',$district->name)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();



     $all_animal_feeds = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Animal Feeds')
     ->where('vendor_services.status','on-sale')
     ->where('is_verified',1)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();



     if(count($animal_feeds) == 0){

         $response = [
             'success'=>false,
             'message'=> "No results found for animal feeds in"." ".$district->name
          ];

          return response()->json($response,404);

     }

     else{



         $response = [
             'success'=>true,
             'data'=>[
                 'total-results'=>count($animal_feeds). " out of ".count($all_animal_feeds)." animal feeds" ,
                  'animal-feeds'=>$animal_feeds
             ],
             'message'=> "Animal Feeds in ".$district->name. " retrieved successfully"
          ];

          return response()->json($response,200);

     }




  }


 //sorting in ascending order

 public function animal_feeds_asc_sort(){

    $animal_feeds =  DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Animal Feeds')
    ->where('vendor_services.status','on-sale')
    ->where('is_verified',1)
    ->orderBy('vendor_services.name','ASC')
    ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
    ->get();




    $response = [
        'success'=>true,
        'data'=>[
            'total-animal-feeds'=>count($animal_feeds),
            'animal-feeds'=>$animal_feeds
        ],
        'message'=> 'Animal Feeds ordered by name in ascending order'
     ];

     return response()->json($response,200);


 }

 public function animal_feeds_desc_sort(){

    $animal_feeds =  DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Animal Feeds')
    ->where('vendor_services.status','on-sale')
    ->where('is_verified',1)
    ->orderBy('vendor_services.name','DESC')
    ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
    ->get();


    $response = [
        'success'=>true,
        'data'=>[
            'total-animal-feeds'=>count($animal_feeds),
            'animal-feeds'=>$animal_feeds
        ],
        'message'=> 'Animal Feeds ordered by name in descending order'
     ];

     return response()->json($response,200);


 }





}
