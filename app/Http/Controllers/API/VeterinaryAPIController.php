<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVeterinaryAPIRequest;
use App\Http\Requests\API\UpdateVeterinaryAPIRequest;
use App\Models\Veterinary;
use App\Repositories\VeterinaryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\VendorCategory;
use App\Models\Address;
use App\Models\User;
use App\Models\District;
use App\Notification\NewVeterinaryNotification;
use DB;
use App\Models\SubCategory;

/**
 * Class VeterinaryController
 * @package App\Http\Controllers\API
 */

class VeterinaryAPIController extends AppBaseController
{
    /** @var  VeterinaryRepository */
    private $veterinaryRepository;

    public function __construct(VeterinaryRepository $veterinaryRepo)
    {
        $this->veterinaryRepository = $veterinaryRepo;
    }

    /**
     * Display a listing of the Veterinary.
     * GET|HEAD /veterinaries
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $veterinaries = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Veterinary')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->paginate(10);

        $response = [
            'success'=>true,
            'data'=>[
                'total-results'=>count($veterinaries),
                'veterinary-services'=>$veterinaries
            ],
            'message'=> "Veterinary services retrieved successfully"
         ];

         return response()->json($response,200);


    }


    //get vet sub categories
       public function vet_sub_categories(Request $request){

    $vet_sub_categories = DB::table('categories')
        ->join('sub_categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Veterinary')
        ->where('sub_categories.is_active',1)
        ->orderBy('sub_categories.name','ASC')
        ->select('sub_categories.id','sub_categories.name',DB::raw("CONCAT('storage/sub_categories/', sub_categories.image) AS image"),'categories.name as category')
        ->get();

        if ($vet_sub_categories->count() == 0) {
            $response = [
                'success'=>false,
                'message'=> 'No sub categories under vet services'
             ];

             return response()->json($response,404);

        }
        else{


            $response = [
                'success'=>true,
                'data'=> [
                    'total-vet-sub-categories' =>count($vet_sub_categories),
                    'vet-sub-categories'=>$vet_sub_categories
                ],
                'message'=> 'Vet sub categories retrieved successfully'
             ];

             return response()->json($response,200);
        }


}


    //vet services under a sub category
    public function subcategory_vet_services(Request $request,$id)
{
    $sub_category = SubCategory::find($id);



    if (empty($sub_category)) {
        $response = [
            'success'=>false,
            'message'=> 'Sub category not found'
         ];

         return response()->json($response,404);

    }

    $vet_services  = DB::table('vendor_services')
                          ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
                          ->join('categories','categories.id','=','sub_categories.category_id')
                          ->where('categories.name','Veterinary')
                          ->where('vendor_services.status','on-sale')->where('is_verified',1)
                          ->where('vendor_services.sub_category_id',$id)
                          ->orderBy('vendor_services.id','DESC')
                          ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
                          ->paginate(10);




    if ($vet_services->count() == 0) {
        $response = [
            'success'=>true,
            'message'=> 'No  vet services have been posted under '.$sub_category->name
         ];

         return response()->json($response,404);

    }
    else{


        $response = [
            'success'=>true,
            'data'=> [
                'total-vet-services' =>$vet_services->count(),
                'vet-services'=>$vet_services
            ],
            'message'=> 'Vet services under '.$sub_category->name.' retrieved successfully'
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


     $veterinary_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Veterinary')
     ->where('is_verified',1)
     ->whereBetween('charge', [$request->min_charge, $request->max_charge])
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->paginate(10);


     if(count($veterinary_services)==0){
        $response = [
            'success'=>false,
            'message'=> "No veterinary services found between"." "."UGX ".$request->min_charge ." and "."UGX ". $request->max_charge
         ];

         return response()->json($response,404);

     }else{

        $response = [
            'success'=>true,
            'data'=>[
                'total-results'=>count($veterinary_services),
                'veterinary-services'=>$veterinary_services
            ],
            'message'=> "Veterinary services between "."UGX ".$request->min_charge ." and "."UGX ". $request->max_charge." "."retrieved successfully"
         ];

         return response()->json($response,200);
     }


    }




 }

 //filter products by location
 public function location_veterinary_services(Request $request){

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


     $veterinary_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Veterinary')
     ->where('is_verified',1)
     ->where('location',$district->name)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->paginate(10);


     $all_veterinary_services = DB::table('vendor_services')
     ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
     ->join('categories','categories.id','=','sub_categories.category_id')
     ->where('categories.name','Veterinary')
     ->where('is_verified',1)
     ->orderBy('vendor_services.id','DESC')
     ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
     ->get();

     if(count($veterinary_services) == 0){

         $response = [
             'success'=>false,
             'message'=> "No results found for veterinary services in"." ".$district->name
          ];

          return response()->json($response,404);

     }

     else{



         $response = [
             'success'=>true,
             'data'=>[
                 'total-results'=>count($veterinary_services). " out of ".count($all_veterinary_services)." veterinary services" ,
                  'veterinary-services'=>$veterinary_services
             ],
             'message'=> "veterinary services in ".$district->name. " retrieved successfully"
          ];

          return response()->json($response,200);

     }




  }


 //sorting in ascending order

 public function veterinary_services_asc_sort(){

    $veterinary_services = DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Veterinary')
    ->where('is_verified',1)
    ->where('location',$district->name)
    ->orderBy('vendor_services.id','ASC')
    ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
    ->paginate(10);



    $response = [
        'success'=>true,
        'data'=>[
            'total-veterinary-services'=>count($veterinary_services),
            'veterinary-services'=>$veterinary_services
        ],
        'message'=> 'Veterinary services ordered by name in ascending order'
     ];

     return response()->json($response,200);


 }

 public function veterinary_services_desc_sort(){

    $veterinary_services = DB::table('vendor_services')
    ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
    ->join('categories','categories.id','=','sub_categories.category_id')
    ->where('categories.name','Veterinary')
    ->where('is_verified',1)
    ->where('location',$district->name)
    ->orderBy('vendor_services.id','DESC')
    ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
    ->paginate(10);



    $response = [
        'success'=>true,
        'data'=>[
            'total-veterinary-services'=>count($veterinary_services),
            'veterinary-services'=>$veterinary_services
        ],
        'message'=> 'Veterinary services ordered by name in descending order'
     ];

     return response()->json($response,200);


 }

    /**
     * Store a newly created Veterinary in storage.
     * POST /veterinaries
     *
     * @param CreateVeterinaryAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:50|unique:veterinaries',
            'expertise' => 'required|string|max:255|min:20',
            'charge' => 'required|integer',
            'charge_unit' => 'nullable',
            'availability' => 'required|string',
            'description' => 'required|string|max:255',
            'location' => 'nullable',
            'image' => 'required|image',
            'animal_categories' =>'required',
        ];

        $request->validate($rules);


        $vendor_category = VendorCategory::where('name','Veterinary')->first();

        $new_vet_service = new Veterinary();
        $new_vet_service->name = $request->name;
        $new_vet_service->charge = $request->charge;
        $new_vet_service->charge_unit = "Per hour";

         $user = User::find(auth()->user()->id);
        if(!$user->is_vendor ==1){
         $user->is_vendor = 1;
         $user->save();
        }
        $new_vet_service->user_id = auth()->user()->id;
        $new_vet_service->vendor_category_id = $vendor_category->id;
        $new_vet_service->expertise = $request->expertise;
        $new_vet_service->image = $request->image;
        $new_vet_service->description = $request->description;
        $new_vet_service->save();

        $new_vet_service->animal_categories()->attach($request->animals);

        $new_vet_service = Veterinary::find($new_vet_service->id);

        $new_vet_service->image = \App\Models\ImageUploader::upload($request->file('image'),'vet');
        $new_vet_service->save();



        if($request->availability == "Online"){
            $request->validate(['zoom_details' => 'required|string']);
            $new_vet_service->zoom_details = $request->zoom_details;
            $new_vet_service->save();
            $admin = User::where('user_type','admin')->first();
            $admin->notify(new NewVeterinaryNotification($new_vet_service));
            $response = [
                'success'=>false,
                'data'=>$new_vet_service,
                'message'=> 'Veterinary Service saved successfully, waiting for verification'
             ];

             return response()->json($response,200);


        }elseif($request->availability == "In-Person"){

            $request->validate(['address_id' => 'required|integer']);
            $location = Address::find($request->address_id);
            $new_vet_service->location= $location->district_name;
            $new_vet_service->save();
            $admin = User::where('user_type','admin')->first();
            $admin->notify(new NewVeterinaryNotification($new_vet_service));
            $response = [
                'success'=>false,
                'data'=>$new_vet_service,
                'message'=> 'Veterinary Service saved successfully.'
             ];

             return response()->json($response,200);



        }else{
            $admin = User::where('user_type','admin')->first();
            $admin->notify(new NewVeterinaryNotification($new_vet_service));
            $response = [
                'success'=>false,
                'data'=>$new_vet_service,
                'message'=> 'Veterinary Service saved successfully.'
             ];

             return response()->json($response,200);
        }


    }

    /**
     * Display the specified Veterinary.
     * GET|HEAD /veterinaries/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Veterinary $veterinary */
        $veterinary = $this->veterinaryRepository->find($id);

        if (empty($veterinary)) {
            return $this->sendError('Veterinary not found');
        }else{

            $success['id'] = $veterinary->id;
            $success['name'] = $veterinary->name;
            $success['expertise'] = $veterinary->expertise;
            $success['description'] = $veterinary->description;
            $success['location'] = $veterinary->location;
            $success['charge'] = $veterinary->charge;
            $success['charge_unit'] = $veterinary->charge_unit;
            $success['vendor'] = $veterinary->user->username;
            $success['image'] = $veterinary->image;
            $success['animal_categories'] = $veterinary->animal_categories()->orderBy('name')->get(['name']);
            $success['availability'] = $veterinary->availability;
            $success['zoom_details'] = $veterinary->zoom_details;
            $success['vendor_category'] = $veterinary->vendor_category->name;
            $success['created_at'] = $veterinary->created_at->format('d/m/Y');
            $success['time_since'] = $veterinary->created_at->diffForHumans();

            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'veterinary Vendor Service retrieved successfullyVeterinary retrieved successfully'
            ];

             return response()->json($response,200);




        }

    }



    //vet services for a vendor
    public function vet_services(Request $request)
    {

       $vet_services = DB::table('vendor_services')
       ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
       ->join('categories','categories.id','=','sub_categories.category_id')
       ->where('categories.name','Veterinary')
       ->where('is_verified',1)
       ->where('user_id',auth()->user()->id)
       ->orderBy('vendor_services.id','DESC')
       ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
       ->get();



       //dd($vet_services);
       $services = [];

        if ($vet_services->count() == 0) {
            return $this->sendError('you havent posted any vet service');
        }
        else{

            foreach($vet_services as $service){
                $services[] = $service;
            }

            $response = [
                'success'=>true,
                'data'=> [
                    'total-vet-services' =>$vet_services->count(),
                    'vet-services'=>$services
                ],
                'message'=> 'Vendor  services for vendor retrieved'
             ];

             return response()->json($response,200);
        }




    }


    public function vet_search(Request $request){
        $search = $request->keyword;

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,400);

        }

        $all_vets = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Veterinary')
        ->where('is_verified',1)
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();

        $vets = DB::table('vendor_services')
        ->join('sub_categories','vendor_services.sub_category_id','=','sub_categories.id')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where('categories.name','Veterinary')
        ->where('is_verified',1)
        ->where('name', 'like', '%' . $search. '%')->orWhere('expertise','like', '%' . $search.'%')
        ->orderBy('vendor_services.id','DESC')
        ->select('vendor_services.*',DB::raw("CONCAT('storage/vendor_services/', vendor_services.image) AS image"))
        ->get();



        if(count($vets) == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>count($vets)." "."results found out of"." ".count($all_vets),
                    'search-results'=>$vets,

                ],

                'message'=> 'search results'
              ];
             return response()->json($response,200);

        }



}
    //get vet shedules
    public function vet_schedules(Request $request,$id)
    {

        $veterinary = $this->veterinaryRepository->find($id);

        if (empty($veterinary)) {
            return $this->sendError('Veterinary service not found');
        }

        $schedules =  $veterinary ->vet_schedules->map(function ($item){
                return collect([
                    'id' => $item->id,
                    'starting_time' => $item->starting_time,
                    'ending_time' => $item->ending_time,
                    'time_interval' => $item->time_interval,
                    'date' => $item->date,
                    'created_at' => $item->created_at->format('d/m/Y'),

                  ]);
        });


        if($veterinary->vet_schedules->count()==0){
            $response = [
                'success'=>false,
                'message'=> 'veterinary service service has no schedules'
             ];
             return response()->json($response,404);

        }else{

            $response = [
                'success'=>true,
                'data'=>[
                    'total-schedules' =>$veterinary->vet_schedules->count(),
                    'schedules'=>$schedules,

                ],
                'message'=> 'veterinary service shedules retrieved successfully '
             ];

             return response()->json($response,200);

        }


    }



    /**
     * Update the specified Veterinary in storage.
     * PUT/PATCH /veterinaries/{id}
     *
     * @param int $id
     * @param UpdateVeterinaryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVeterinaryAPIRequest $request)
    {
        $input = $request->all();

        /** @var Veterinary $veterinary */
        $veterinary = $this->veterinaryRepository->find($id);

        if (empty($veterinary)) {
            return $this->sendError('Veterinary not found');
        }

        $veterinary = $this->veterinaryRepository->update($input, $id);

        return $this->sendResponse($veterinary->toArray(), 'Veterinary updated successfully');
    }

    /**
     * Remove the specified Veterinary from storage.
     * DELETE /veterinaries/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Veterinary $veterinary */
        $veterinary = $this->veterinaryRepository->find($id);

        if (empty($veterinary)) {
            return $this->sendError('Veterinary not found');
        }

        $veterinary->delete();

        return $this->sendSuccess('Veterinary deleted successfully');
    }
}
