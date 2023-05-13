<?php

namespace App\Http\Controllers\API;


use App\Models\VendorService;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Crop;
use App\Models\Category;
use App\Models\Address;
use App\Models\User;
use App\Models\District;
use App\Notifications\NewAgronomistNotification;
use DB;
/**use App\Models\VendorCategory;

 * Class AgronomistVendorServiceController
 * @package App\Http\Controllers\API
 */

class AgronomistVendorServiceAPIController extends Controller
{


   //get agronomists under a crop
   public function crop_agromonomist_service(Request $request,$id)
   {

      $crop= Crop::find($id);
      $animal_feeds = DB::table('crop_vendor_service')
                      ->join('crops','crops.id','=','crop_vendor_service.crop_id')
                      ->join('vendor_Services','vendor_Services.id','=','crop_vendor_service.vendor_Service_id')
                      ->where('vendor_Services.is_verified',1)
                      ->where('crops.id',$id)
                      ->orderBy('vendor_Services.id','DESC')
                      ->select('vendor_services.id as id','vendor_services.name as name','crops.name as crop','vendor_services.image','description','charge_unit','charge','is_verified','location')
                      ->get();

  // dd($animal_feeds);

       $response = [
           'success'=>true,
           'data'=> [
              'total-animal-feeds'=>count($animal_feeds),
              'animal-category'=>$animal_category->name,
              'animal-category-type'=>$animal_category->type,
              'animal-feeds' =>  $animal_feeds
           ],
           'message'=> 'Animal feeeds under'.$animal_category .' retrieved successfully'
        ];
        return response()->json($response,200);
   }

    //vendor agro services
    public function vendor_agro_services(Request $request){


        $agro_services = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Agronomist')
        ->where('is_verified',1)
        ->where('vendor_services.user_id',auth()->user()->id)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();


        if ($agro_services->count() == 0) {

            $response = [
                'success'=>false,
                'message'=> "You haven't posted any agro service"
             ];

             return response()->json($response,404);

        }
        else{



            $response = [
                'success'=>true,
                'data'=> [
                    'total-agro-services' =>$agro_services->count(),
                    'agro-services'=>$agro_services
                ],
                'message'=> 'Vendor agro services  retrieved'
             ];

             return response()->json($response,200);
        }
    }


    public function agronomist_search(Request $request){
        $search = $request->keyword;

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,404);

        }

        $all_ago_services = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Agronomists')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();


        $agronomists = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Agronomists')
        ->where('is_verified',1)
        ->where('name', 'like', '%' . $search. '%')
        ->orWhere('expertise','like', '%' . $search.'%')
        ->orderBy('vendor_services.id','ASC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();



        if(count($agronomists) == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>count($agronomists)." "."results found out of"." ".count($all_ago_services),
                    'search-results'=>$agronomists,

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


     $agronomist_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Agronomists')
     ->where('is_verified',1)
     ->whereBetween('charge', [$request->min_charge, $request->max_charge])
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();



     if(count($agronomist_services)==0){
        $response = [
            'success'=>false,
            'message'=> "No agronomist services found between"." "."UGX ".$request->min_charge ." and "."UGX ". $request->max_charge
         ];

         return response()->json($response,404);

     }else{

        $response = [
            'success'=>true,
            'data'=>[
                'total-results'=>count($agronomist_services),
                'agronomist-services'=>$agronomist_services
            ],
            'message'=> "Agronomist services between "."UGX ".$request->min_charge ." and "."UGX ". $request->max_charge." "."retrieved successfully"
         ];

         return response()->json($response,200);
     }


    }




 }

 //filter products by location
 public function location_agronomist_services(Request $request){

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


     $agronomist_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Agronomists')
     ->where('is_verified',1)
     ->where('location',$district->name)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();


     $all_agronomist_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Agronomists')
     ->where('is_verified',1)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();


     if(count($agronomist_services) == 0){

         $response = [
             'success'=>false,
             'message'=> "No results found for agronomist services in"." ".$district->name
          ];

          return response()->json($response,404);

     }

     else{



         $response = [
             'success'=>true,
             'data'=>[
                 'total-results'=>count($agronomist_services). " out of ".count($all_agronomist_services)." agronomist services" ,
                  'agronomist-services'=>$agronomist_services
             ],
             'message'=> "agronomist services in ".$district->name. " retrieved successfully"
          ];

          return response()->json($response,200);

     }




  }


 //sorting in ascending order

 public function agronomist_services_asc_sort(){

    $agronomist_services = DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Agronomists')
    ->where('is_verified',1)
    ->orderBy('vendor_services.id','ASC')
    ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
    ->get();



    $response = [
        'success'=>true,
        'data'=>[
            'total-agronomist-services'=>count($agronomist_services),
            'agronomist-services'=>$agronomist_services
        ],
        'message'=> 'Agronomist services ordered by name in ascending order'
     ];

     return response()->json($response,200);


 }

 public function agronomist_services_desc_sort(){

    $agronomist_services = DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Agronomists')
    ->where('is_verified',1)
    ->orderBy('vendor_services.id','DESC')
    ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
    ->get();




    $response = [
        'success'=>true,
        'data'=>[
            'total-agronomist-services'=>count($agronomist_services),
            'agronomist-services'=>$agronomist_services
        ],
        'message'=> 'agronomist services ordered by name in descending order'
     ];

     return response()->json($response,200);


 }
    /**
     * Store a newly created AgronomistVendorService in storage.
     * POST /agronomistVendorServices
     *
     * @param CreateAgronomistVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:50|unique:agronomists',
            'expertise' => 'required|string|max:255|min:20',
            'charge' => 'required|integer',
            'charge_unit' => 'nullable',
            'availability' => 'required|string',
            'description' => 'required|string|max:255',
            'location' => 'nullable',
            'image' => 'required|image',
            'crops' =>'required',
        ];

        $request->validate($rules);

       //dd($request->all());
        $vendor_category = VendorCategory::where('name','Agronomists')->first();

        $new_agro_service = new AgronomistVendorService();
        $new_agro_service->name = $request->name;
        $new_agro_service->charge = $request->charge;
        $new_agro_service->charge_unit = "Per hour";

        $user = User::find(auth()->user()->id);
        if(!$user->is_vendor ==1){
         $user->is_vendor =1;
         $user->save();
        }
        $new_agro_service->user_id = auth()->user()->id;
        $new_agro_service->vendor_category_id = $vendor_category->id;
        $new_agro_service->expertise = $request->expertise;
        $new_agro_service->image = $request->image;
        $new_agro_service->description = $request->description;
        $new_agro_service->save();

        $new_agro_service->crops()->attach($request->crops);

        $new_agro_service = AgronomistVendorService::find($new_agro_service->id);

        $new_agro_service->image = \App\Models\ImageUploader::upload($request->file('image'),'agronomists');
        $new_agro_service->save();



        if($request->availability == "Online"){
            $request->validate(['zoom_details' => 'required|string']);
            $new_agro_service->zoom_details = $request->zoom_details;
            $new_agro_service->save();

            $admin = User::where('user_type','admin')->first();
            $admin->notify(new NewAgronomistNotification($new_agro_service));
            $response = [
                'success'=>false,
                'data'=>$new_agro_service,
                'message'=> 'Agronomist Vendor Service created, waiting for verification.'
             ];

             return response()->json($response,201);


        }elseif($request->availability == "In-Person"){

            $request->validate(['address_id' => 'required|integer']);
            $location = Address::find($request->address_id);
            $new_agro_service->location= $location->district_name;
            $new_agro_service->save();
            $admin = User::where('user_type','admin')->first();
            $admin->notify(new NewAgronomistNotification($new_agro_service));
            $response = [
                'success'=>false,
                'data'=>$new_agro_service,
                'message'=> 'Agronomist Vendor Service created,waiting for verification.'
             ];

             return response()->json($response,201);



        }else{
            $admin = User::where('user_type','admin')->first();
            $admin->notify(new NewAgronomistNotification($new_agro_service));
            $response = [
                'success'=>false,
                'data'=>$new_agro_service,
                'message'=> 'Agronomist Vendor Service created, waiting for verification'
             ];

             return response()->json($response,200);
        }

    }

    /**
     * Display the specified AgronomistVendorService.
     * GET|HEAD /agronomistVendorServices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AgronomistVendorService $agronomistVendorService */
        $agronomistVendorService = $this->agronomistVendorServiceRepository->find($id);

        if (empty($agronomistVendorService)) {
            return $this->sendError('Agronomist Vendor Service not found');
        }else{

            $success['id'] = $agronomistVendorService->id;
            $success['name'] = $agronomistVendorService->name;
            $success['expertise'] = $agronomistVendorService->expertise;
            $success['description'] = $agronomistVendorService->description;
            $success['location'] = $agronomistVendorService->location;
            $success['charge'] = $agronomistVendorService->charge;
            $success['charge_unit'] =$agronomistVendorService->charge_unit;
            $success['vendor'] = $agronomistVendorService->user->username;
            $success['image'] = $agronomistVendorService->image;
            $success['crops'] = $agronomistVendorService->crops()->orderBy('name')->get(['name']);
            $success['availability'] = $agronomistVendorService->availability;
            $success['zoom_details'] = $agronomistVendorService->zoom_details;
            $success['vendor_category'] = $agronomistVendorService->vendor_category->name;
            $success['created_at'] = $agronomistVendorService->created_at->format('d/m/Y');
            $success['time_since'] = $agronomistVendorService->created_at->diffForHumans();

        }
        $response = [
            'success'=>true,
            'data'=> $success,
            'message'=> 'Agronomist Vendor Service retrieved successfully'
         ];

         return response()->json($response,200);


    }


    //get agronomist shedules
    public function agronomist_schedules(Request $request,$id)
    {

        $agronomistVendorService = $this->agronomistVendorServiceRepository->find($id);

        if (empty($agronomistVendorService)) {
            return $this->sendError('Agronomist Vendor Service not found');
        }

        $schedules =  $agronomistVendorService->agronomist_schedules->map(function ($item){
                return collect([
                    'id' => $item->id,
                    'starting_time' => $item->starting_time,
                    'ending_time' => $item->ending_time,
                    'time_interval' => $item->time_interval,
                    'day' => $item->date,
                    'created_at' => $item->created_at->format('d/m/Y'),

                  ]);
        });


        if($agronomistVendorService->agronomist_schedules->count()==0){
            $response = [
                'success'=>false,
                'message'=> 'agronomist vendor service has no schedules'
             ];
             return response()->json($response,404);

        }else{

            $response = [
                'success'=>true,
                'data'=>[
                    'total-schedules' =>$agronomistVendorService->agronomist_schedules->count(),
                    'schedules'=>$schedules,

                ],
                'message'=> 'agronomist Vendor Service shedules retrieved successfully '
             ];

             return response()->json($response,200);

        }


    }





    /**
     * Update the specified AgronomistVendorService in storage.
     * PUT/PATCH /agronomistVendorServices/{id}
     *
     * @param int $id
     * @param UpdateAgronomistVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgronomistVendorServiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var AgronomistVendorService $agronomistVendorService */
        $agronomistVendorService = $this->agronomistVendorServiceRepository->find($id);

        if (empty($agronomistVendorService)) {
            return $this->sendError('Agronomist Vendor Service not found');
        }

        $agronomistVendorService = $this->agronomistVendorServiceRepository->update($input, $id);

        return $this->sendResponse($agronomistVendorService->toArray(), 'AgronomistVendorService updated successfully');
    }

    /**
     * Remove the specified AgronomistVendorService from storage.
     * DELETE /agronomistVendorServices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AgronomistVendorService $agronomistVendorService */
        $agronomistVendorService = $this->agronomistVendorServiceRepository->find($id);

        if (empty($agronomistVendorService)) {
            return $this->sendError('Agronomist Vendor Service not found');
        }

        $agronomistVendorService->delete();

        return $this->sendSuccess('Agronomist Vendor Service deleted successfully');
    }
}
