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
        $veterinaries = $this->veterinaryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($veterinaries->toArray(), 'Veterinaries retrieved successfully');
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
            $response = [
                'success'=>false,
                'data'=>$new_vet_service,
                'message'=> 'Veterinary Service saved successfully.'
             ];

             return response()->json($response,200);


        }elseif($request->availability == "In-Person"){

            $request->validate(['address_id' => 'required|integer']);
            $location = Address::find($request->address_id);
            $new_vet_service->location= $location->district_name;
            $new_vet_service->save();
            $response = [
                'success'=>false,
                'data'=>$new_vet_service,
                'message'=> 'Veterinary Service saved successfully.'
             ];

             return response()->json($response,200);



        }else{
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
            $success['charge'] = $veterinary->charge."".$veterinary->charge_unit;
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
                'message'=> 'Agronomist Vendor Service retrieved successfullyVeterinary retrieved successfully'
            ];

             return response()->json($response,200);




        }

    }



    //vet services for a vendor
    public function vet_services(Request $request)
    {

       $vet_services = Veterinary::with('animal_categories')->where('user_id',auth()->user()->id)->latest()->get();

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
