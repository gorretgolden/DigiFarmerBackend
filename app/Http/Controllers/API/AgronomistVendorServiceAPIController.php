<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAgronomistVendorServiceAPIRequest;
use App\Http\Requests\API\UpdateAgronomistVendorServiceAPIRequest;
use App\Models\AgronomistVendorService;
use App\Repositories\AgronomistVendorServiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Crop;
use App\Models\VendorCategory;
use App\Models\Address;
use App\Models\User;
/**use App\Models\VendorCategory;

 * Class AgronomistVendorServiceController
 * @package App\Http\Controllers\API
 */

class AgronomistVendorServiceAPIController extends AppBaseController
{
    /** @var  AgronomistVendorServiceRepository */
    private $agronomistVendorServiceRepository;

    public function __construct(AgronomistVendorServiceRepository $agronomistVendorServiceRepo)
    {
        $this->agronomistVendorServiceRepository = $agronomistVendorServiceRepo;
    }

    /**
     * Display a listing of the AgronomistVendorService.
     * GET|HEAD /agronomistVendorServices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $agronomistVendorServices = $this->agronomistVendorServiceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($agronomistVendorServices->toArray(), 'Agronomist Vendor Services retrieved successfully');
    }

    //vendor agro services
    public function vendor_agro_services(Request $request){


        $agro_services = AgronomistVendorService::where('user_id',auth()->user()->id)->latest()->get();


        if ($agro_services->count() == 0) {
            return $this->sendError("You haven't posted any agro service");
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
            $response = [
                'success'=>false,
                'data'=>$new_agro_service,
                'message'=> 'Agronomist Vendor Service saved successfully.'
             ];

             return response()->json($response,200);


        }elseif($request->availability == "In-Person"){

            $request->validate(['address_id' => 'required|integer']);
            $location = Address::find($request->address_id);
            $new_agro_service->location= $location->district_name;
            $new_agro_service->save();
            $response = [
                'success'=>false,
                'data'=>$new_agro_service,
                'message'=> 'Agronomist Vendor Service saved successfully.'
             ];

             return response()->json($response,200);



        }else{
            $response = [
                'success'=>false,
                'data'=>$new_agro_service,
                'message'=> 'Agronomist Vendor Service saved successfully.'
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
            $success['charge'] = $agronomistVendorService->charge."".$agronomistVendorService->charge_unit;
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
