<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTrainingVendorServiceAPIRequest;
use App\Http\Requests\API\UpdateTrainingVendorServiceAPIRequest;
use App\Models\TrainingVendorService;
use App\Repositories\TrainingVendorServiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Carbon\Carbon;
use App\Models\User;
use App\Models\VendorCategory;
/**
 * Class TrainingVendorServiceController
 * @package App\Http\Controllers\API
 */

class TrainingVendorServiceAPIController extends AppBaseController
{
    /** @var  TrainingVendorServiceRepository */
    private $trainingVendorServiceRepository;

    public function __construct(TrainingVendorServiceRepository $trainingVendorServiceRepo)
    {
        $this->trainingVendorServiceRepository = $trainingVendorServiceRepo;
    }

    /**
     * Display a listing of the TrainingVendorService.
     * GET|HEAD /trainingVendorServices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $trainingVendorServices =  TrainingVendorService::where('is_verified',1)->latest()->get();
        return $this->sendResponse($trainingVendorServices->toArray(), 'Training Vendor Services retrieved successfully');
    }

    /**
     * Store a newly created TrainingVendorService in storage.
     * POST /trainingVendorServices
     *
     * @param CreateTrainingVendorServiceAPIRequest $request
     *
     * @return Response
     */


      //training vendor services for a single vendor
    public function vendorTrainings(Request $request)
    {
        $vendor_trainings = TrainingVendorService::with('vendor_category')->where('user_id',auth()->user()->id)->get();

        if($vendor_trainings->count()==0){
            $response = [
                'success'=>false,

                'message'=> 'vendor has no training services'
             ];
             return response()->json($response,200);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-training-services'=>$vendor_trainings->count(),
                    'training-vendor-services'=>$vendor_trainings

                ],

                'message'=> 'vendor training services retrieved successfully'
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

        $all_trainings = TrainingVendorService::where('is_verified',1)->get();
        $trainings = TrainingVendorService::where('is_verified',1)->where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();


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

    public function store(Request $request)
    {

        $rules = [

            'name' => 'required|string|unique:training_vendor_services',
            'charge' => 'required|integer',
            'description' => 'required|string',
            'access' => 'required|string',
            'starting_date' => 'required|date',
            'ending_date' => 'required|after_or_equal:starting_date',
            'starting_time' => 'required|before:ending_time',
            'ending_time' => 'required|after:starting_time',
            'location' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ];

        $request->validate($rules);
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        $user = User::find(auth()->user()->id);
        if(!$user->is_vendor ==1){
         $user->is_vendor = 1;
         $user->save();
        }
        $vendor_category = VendorCategory::where('name','Training')->first();

        //access
        if($input['access']=='Online'){
            $request->validate(['zoom_details' => 'required|string']);
            $input['zoom_details'] = $request->zoom_details;

            $input['vendor_category_id'] = $vendor_category->id;
            $trainingVendorService = $this->trainingVendorServiceRepository->create($input);

            $trainingVendorService->image= \App\Models\ImageUploader::upload($request->file('image'),'trainings');
            $trainingVendorService->save();
            return $this->sendResponse($trainingVendorService->toArray(), 'Training Vendor Service saved successfully');


        }else{
            if($input['access']=='Offline'){

                $request->validate(['address_id' => 'required|integer']);
                $location = Address::find($request->address_id);
                $input['vendor_category_id'] = $vendor_category->id;
                $input['location'] = $location->district_name;
                $trainingVendorService->image= \App\Models\ImageUploader::upload($request->file('image'),'trainings');
                $trainingVendorService->save();
                $trainingVendorService = $this->trainingVendorServiceRepository->create($input);
                return $this->sendResponse($trainingVendorService->toArray(), 'Training Vendor Service created successfully, waiting for verification');
            }


        }



    }

    // public function vendorTrainings(Request $request){

    //     $vendor = User::find(auth()->user()->id);
    //     $training_services = $vendor->training_vendor_services;
    //     if($training_services->count()== 0){

    //         $response = [
    //             'success'=>true,
    //             'message'=>'Vendor has no training vendor services'
    //            ];

    //            return response()->json($response,200);
    //     }
    //     else{
    //         $response = [
    //             'success'=>true,
    //             'data' => $training_services,
    //             'message'=>'Training vendor services retrieved successfully'
    //            ];

    //            return response()->json($response,200);

    //     }

    // }

    /**
     * Display the specified TrainingVendorService.
     * GET|HEAD /trainingVendorServices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var TrainingVendorService $trainingVendorService */
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            return $this->sendError('Training Vendor Service not found');
        }else{
            $success['id'] = $trainingVendorService->id;
            $success['name'] = $trainingVendorService->name;
            $success['charge'] = $trainingVendorService->charge;
            $success['description'] = $trainingVendorService->description;
            $success['location'] = $trainingVendorService->location;
            $success['charge'] = $trainingVendorService->charge;
            $success['vendor'] = $trainingVendorService->vendor->username;
            $success['image'] = $trainingVendorService->image;
            $success['access'] = $trainingVendorService->access;
            $success['starting_date'] = $trainingVendorService->starting_date;
            $success['starting_time'] = $trainingVendorService->starting_time;
            $success['ending_date'] = $trainingVendorService->ending_date;
            $success['ending_time'] = $trainingVendorService->ending_time;
            $success['zoom_details'] = $trainingVendorService->zoom_details;
            $success['vendor_category'] = $trainingVendorService->vendor_category->name;
            $success['created_at'] = $trainingVendorService->created_at->format('d/m/Y');
            $success['time_since'] = $trainingVendorService->created_at->diffForHumans();
        }
        $response = [
            'success'=>true,
            'data'=> $success,
            'message'=> 'Training Vendor Service retrieved successfully'
         ];
         return response()->json($response,200);
    }

    /**
     * Update the specified TrainingVendorService in storage.
     * PUT/PATCH /trainingVendorServices/{id}
     *
     * @param int $id
     * @param UpdateTrainingVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTrainingVendorServiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var TrainingVendorService $trainingVendorService */
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            return $this->sendError('Training Vendor Service not found');
        }

        $trainingVendorService = $this->trainingVendorServiceRepository->update($input, $id);

        return $this->sendResponse($trainingVendorService->toArray(), 'TrainingVendorService updated successfully');
    }

    /**
     * Remove the specified TrainingVendorService from storage.
     * DELETE /trainingVendorServices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var TrainingVendorService $trainingVendorService */
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            return $this->sendError('Training Vendor Service not found');
        }

        $trainingVendorService->delete();

        return $this->sendSuccess('Training Vendor Service deleted successfully');
    }
}
