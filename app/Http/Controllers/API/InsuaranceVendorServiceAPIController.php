<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInsuaranceVendorServiceAPIRequest;
use App\Http\Requests\API\UpdateInsuaranceVendorServiceAPIRequest;
use App\Models\InsuaranceVendorService;
use App\Repositories\InsuaranceVendorServiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\VendorCategory;
use App\Models\Address;
use App\Models\User;

/**
 * Class InsuaranceVendorServiceController
 * @package App\Http\Controllers\API
 */

class InsuaranceVendorServiceAPIController extends AppBaseController
{
    /** @var  InsuaranceVendorServiceRepository */
    private $insuaranceVendorServiceRepository;

    public function __construct(InsuaranceVendorServiceRepository $insuaranceVendorServiceRepo)
    {
        $this->insuaranceVendorServiceRepository = $insuaranceVendorServiceRepo;
    }

    /**
     * Display a listing of the InsuaranceVendorService.
     * GET|HEAD /insuaranceVendorServices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $insuaranceVendorServices = InsuaranceVendorService::where('is_verified',1)->latest()->get();
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
    //home

    public function home_insurance_vendors(Request $request)
    {
        $insuaranceVendorServices = InsuaranceVendorService::where('is_verified',1)->limit(4)->get();
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
        $all_services = InsuaranceVendorService::where('is_verified',1)->get();
        $insurance = InsuaranceVendorService::where('is_verified',1)->where('name', 'like', '%' . $search. '%')->orWhere('terms','like', '%' . $search.'%')->get();


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

    /**
     * Store a newly created InsuaranceVendorService in storage.
     * POST /insuaranceVendorServices
     *
     * @param CreateInsuaranceVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|unique:insuarance_vendor_services',
            'terms' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image',
            'address_id'=>'required|integer'

        ];
        $request->validate($rules);

        $vendor_category = VendorCategory::where('name','Insuarance')->first();
        $location = Address::find($request->address_id);

        $new_insuarance = new InsuaranceVendorService();
        $new_insuarance->name = $request->name;
        $new_insuarance->terms = $request->terms;
        $new_insuarance->description = $request->description;

        $user = User::find(auth()->user()->id);
        if(!$user->is_vendor ==1){
         $user->is_vendor = 1;
         $user->save();
        }
        $new_insuarance->user_id = auth()->user()->id;
        $new_insuarance->vendor_category_id = $vendor_category->id;
        $new_insuarance->image = $request->image;
        $new_insuarance->location = $location->district_name;
        $new_insuarance->save();


        if(!empty($request->file('image'))){
            $new_insuarance->image = \App\Models\ImageUploader::upload($request->file('image'),'insuarance_services');
        }
        $new_insuarance->save();

        return $this->sendResponse($new_insuarance->toArray(), 'Insuarance Vendor Service, waiting for verification');
    }

    /**
     * Display the specified InsuaranceVendorService.
     * GET|HEAD /insuaranceVendorServices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var InsuaranceVendorService $insuaranceVendorService */
        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->find($id);

        if (empty($insuaranceVendorService)) {
            return $this->sendError('Insuarance Vendor Service not found');
        }else{
            $success['name'] = $insuaranceVendorService->name;
            $success['image'] = $insuaranceVendorService->image;
            $success['terms'] = $insuaranceVendorService->terms;
            $success['description'] = $insuaranceVendorService->description;
            $success['vendor'] = $insuaranceVendorService->user->username;
            $success['location'] = $insuaranceVendorService->location;
            $success['created_at'] = $insuaranceVendorService->created_at->format('d/m/Y');
            $success['time_since'] = $insuaranceVendorService->created_at->diffForHumans();
        }
        $response = [
            'success'=>true,
            'data'=> $success,
            'message'=> 'Insuarance Vendor Service retrieved successfully'
         ];

         return response()->json($response,200);


    }


       //get insurance vendors for a vendor
       public function vendor_insurance_services(Request $request)
       {

          $vendor_insurances = InsuaranceVendorService::where('user_id',auth()->user()->id)->latest()->get();


           if ($vendor_insurances->count() == 0) {
               return $this->sendError("You haven't posted any insurance service");
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
    /**
     * Update the specified InsuaranceVendorService in storage.
     * PUT/PATCH /insuaranceVendorServices/{id}
     *
     * @param int $id
     * @param UpdateInsuaranceVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInsuaranceVendorServiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var InsuaranceVendorService $insuaranceVendorService */
        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->find($id);

        if (empty($insuaranceVendorService)) {
            return $this->sendError('Insuarance Vendor Service not found');
        }

        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->update($input, $id);

        return $this->sendResponse($insuaranceVendorService->toArray(), 'InsuaranceVendorService updated successfully');
    }

    /**
     * Remove the specified InsuaranceVendorService from storage.
     * DELETE /insuaranceVendorServices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var InsuaranceVendorService $insuaranceVendorService */
        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->find($id);

        if (empty($insuaranceVendorService)) {
            return $this->sendError('Insuarance Vendor Service not found');
        }

        $insuaranceVendorService->delete();

        return $this->sendSuccess('Insuarance Vendor Service deleted successfully');
    }
}
