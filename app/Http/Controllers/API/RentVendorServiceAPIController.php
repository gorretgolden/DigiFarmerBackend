<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRentVendorServiceAPIRequest;
use App\Http\Requests\API\UpdateRentVendorServiceAPIRequest;
use App\Models\RentVendorService;
use App\Repositories\RentVendorServiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\VendorCategory;
use App\Models\RentVendorSubCategory;
use App\Models\Address;
use App\Models\User;

/**
 * Class RentVendorServiceController
 * @package App\Http\Controllers\API
 */

class RentVendorServiceAPIController extends AppBaseController
{
    /** @var  RentVendorServiceRepository */
    private $rentVendorServiceRepository;

    public function __construct(RentVendorServiceRepository $rentVendorServiceRepo)
    {
        $this->rentVendorServiceRepository = $rentVendorServiceRepo;
    }

    /**
     * Display a listing of the RentVendorService.
     * GET|HEAD /rentVendorServices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rentVendorServices = RentVendorService::where('is_verified',1)->latest()->get(['id','name','location','image','charge','charge_frequency','charge_unit','description','status','created_at']);
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

    public function home_rent_vendors(Request $request)
    {
        $rentVendorServices = RentVendorService::where('is_verified',1)->latest()->limit(4)->get();
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


    public function rent_search(Request $request){
        $search = $request->keyword;

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,200);

        }

        $all_rent = RentVendorService::where('is_verified',1)->get();
        $rent = RentVendorService::where('is_verified',1)->where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();


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

    /**
     * Store a newly created RentVendorService in storage.
     * POST /rentVendorServices
     *
     * @param CreateRentVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required|string|unique:rent_vendor_services|min:10|max:30',
            'rent_vendor_sub_category_id' => 'required|integer',
            'charge' => 'required|integer|min:500',
            'description' => 'required|string|min:20|max:1000',
            'image' => 'required|image',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:5048',
            'quantity'=> 'required|integer',
            'charge_frequency'=> 'required|string',
            'address_id'=>'required|integer'

        ];

        $request->validate($rules);
        $input = $request->all();
        $vendor_category = VendorCategory::where('name','Rent')->first();
        $location = Address::find($request->address_id);


        $rent_vendor_service = new RentVendorService();
        $rent_vendor_service->name = $request->name;
        $rent_vendor_service->rent_vendor_sub_category_id = $request->rent_vendor_sub_category_id;
        $rent_vendor_service->charge = $request->charge;
        $rent_vendor_service->quantity = $request->quantity;
        $rent_vendor_service->status = 'available for rent';
        $rent_vendor_service->charge_frequency = $request->charge_frequency;
        $rent_vendor_service->image = $request->image;

        $user = User::find(auth()->user()->id);
        if(!$user->is_vendor ==1){
         $user->is_vendor = 1;
         $user->save();
        }
        $rent_vendor_service->user_id = auth()->user()->id;
        $rent_vendor_service->location = $location->district_name;
        $rent_vendor_service->description = $request->description;
        $rent_vendor_service->vendor_category_id = $vendor_category->id;
        $rent_vendor_service->save();


        if(!empty($request->file('image'))){
            $rent_vendor_service->image = \App\Models\ImageUploader::upload($request->file('image'),'rent');
        }
        $rent_vendor_service->save();


        // if($request->hasFile('images')){

        //     foreach ($request->file('images') as $imagefile) {
        //         $image = new RentVendorImage();
        //         $path = $imagefile->store('/storage/rent', ['disk' =>   'rent-images']);
        //         $image->url = $path;
        //         $image->rent_vendor_service_id = $rent_vendor_service->id;
        //         $image->save();
        //       }
        // }

        return $this->sendResponse($rent_vendor_service->toArray(), 'Rent Vendor Service created, waiting for verification');
    }

    /**
     * Display the specified RentVendorService.
     * GET|HEAD /rentVendorServices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var RentVendorService $rentVendorService */
        $rentVendorService = $this->rentVendorServiceRepository->find($id);
        $rent_vendor_images = $rentVendorService->images;




        if (empty($rentVendorService)) {
            return $this->sendError('Rent Vendor Service not found');
        }else{

            $success['name'] = $rentVendorService->name;
            $success['location'] = $rentVendorService->location;
            $success['charge'] = $rentVendorService->charge;
            $success['charge_unit'] = $rentVendorService->charge_unit;
            $success['charge_frequency'] = $rentVendorService->charge_frequency;
            $success['status'] = $rentVendorService->status;
            $success['description'] = $rentVendorService->description;
            $success['vendor'] = $rentVendorService->vendor->username;
            $success['rent_category'] = $rentVendorService->rent_vendor_sub_category->rent_category->name;
            $success['rent_sub_category'] = $rentVendorService->rent_vendor_sub_category->name;
            $success['created_at'] = $rentVendorService->created_at->format('d/m/Y');
            $success['time_since'] = $rentVendorService->created_at->diffForHumans();
            $success['image']= $rentVendorService->image;
            // $success['image'] = $rentVendorService->images()->get(['id','url']);
        }
        $response = [
            'success'=>true,
            'data'=> $success,
            'message'=> 'Rent Vendor Service retrieved successfully'
         ];

         return response()->json($response,200);


    }


    //get vendor rent services
    public function vendorRentService(Request $request)
    {

       $rent_vendor_services = RentVendorService::where('user_id',auth()->user()->id)->latest()->get();




        if ($rent_vendor_services->count() == 0) {
            return $this->sendError('You havent posted any rent services');
        }
        else{


            $response = [
                'success'=>true,
                'data'=> [
                    'total-rent-services' =>$rent_vendor_services->count(),
                    'rent-services'=>$rent_vendor_services
                ],
                'message'=> 'Vendor animal feeds retrieved'
             ];

             return response()->json($response,200);
        }




    }


    //get rent sub categories for a category
    public function rent_sub_categories(Request $request,$id)
    {


      $data['rent-sub-categories'] = RentVendorSubCategory::where("rent_vendor_category_id", $id)->get(['name','id']);

        return response()->json($data);
    }
    /**
     * Update the specified RentVendorService in storage.
     * PUT/PATCH /rentVendorServices/{id}
     *
     * @param int $id
     * @param UpdateRentVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRentVendorServiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var RentVendorService $rentVendorService */
        $rentVendorService = $this->rentVendorServiceRepository->find($id);

        if (empty($rentVendorService)) {
            return $this->sendError('Rent Vendor Service not found');
        }

        $rentVendorService = $this->rentVendorServiceRepository->update($input, $id);

        return $this->sendResponse($rentVendorService->toArray(), 'RentVendorService updated successfully');
    }

    /**
     * Remove the specified RentVendorService from storage.
     * DELETE /rentVendorServices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var RentVendorService $rentVendorService */
        $rentVendorService = $this->rentVendorServiceRepository->find($id);

        if (empty($rentVendorService)) {
            return $this->sendError('Rent Vendor Service not found');
        }

        $rentVendorService->delete();

        return $this->sendSuccess('Rent Vendor Service deleted successfully');
    }
}
