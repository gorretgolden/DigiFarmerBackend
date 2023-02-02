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
        $rentVendorServices = RentVendorService::with('images')->latest()->get(['id','name','location','charge','charge_frequency','charge_unit','description','status','created_at']);
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
        $rentVendorServices = RentVendorService::with('images')->limit(4)->get();
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
            'charge' => 'required|integer',
            'description' => 'required|string|min:20|max:1000',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5048',
            'images' => 'max:3',
            // 'address_id' => 'required|integer',
            'quantity'=> 'required|integer'

        ];
        $request->validate($rules);
        $input = $request->all();
        $vendor_category = VendorCategory::where('name','Rent')->first();
        $location = Address::where('id',2)->first();


        $rent_vendor_service = new RentVendorService();
        $rent_vendor_service->name = $request->name;
        $rent_vendor_service->rent_vendor_sub_category_id = $request->rent_vendor_sub_category_id;
        $rent_vendor_service->charge = $request->charge;
        $rent_vendor_service->quantity = $request->quantity;
        $rent_vendor_service->status = 'available for rent';

        $user = User::find(auth()->user()->id);
        if(!$user->is_vendor ==1){
         $user->is_vendor = 1;
         $user->save();
        }
        $rent_vendor_service->user_id = auth()->user()->id;
        $rent_vendor_service->location = $location->district_name;
        $rent_vendor_service->charge_frequency = "per day";
        $rent_vendor_service->description = $request->description;
        $rent_vendor_service->vendor_category_id = $vendor_category->id;
        $rent_vendor_service->save();

        // //update time since
        // $rent_vendor_service->time_since = $rent_vendor_service->created_at->diffForHumans();
        // $rent_vendor_service->save();

        if($request->hasFile('images')){

            foreach ($request->file('images') as $imagefile) {
                $image = new RentVendorImage();
                $path = $imagefile->store('/storage/rent', ['disk' =>   'rent-images']);
                $image->url = $path;
                $image->rent_vendor_service_id = $rent_vendor_service->id;
                $image->save();
              }
        }

        return $this->sendResponse($rent_vendor_service->toArray(), 'Rent Vendor Service saved successfully');
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
            $success['charge'] = $rentVendorService->charge_unit." ".$rentVendorService ->charge;
            $success['status'] = $rentVendorService->status;
            $success['description'] = $rentVendorService->description;
            $success['vendor'] = $rentVendorService->vendor->username;
            $success['rent_category'] = $rentVendorService->rent_vendor_sub_category->rent_category->name;
            $success['rent_sub_category'] = $rentVendorService->rent_vendor_sub_category->name;
            $success['created_at'] = $rentVendorService->created_at->format('d/m/Y');
            $success['time_since'] = $rentVendorService->created_at->diffForHumans();
            $success['images'] = $rentVendorService->images()->get(['id','url']);
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
