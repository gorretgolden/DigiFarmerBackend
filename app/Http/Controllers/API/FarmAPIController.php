<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFarmAPIRequest;
use App\Http\Requests\API\UpdateFarmAPIRequest;
use App\Models\Farm;
use App\Repositories\FarmRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Validator;
use App\Models\User;

/**
 * Class FarmController
 * @package App\Http\Controllers\API
 */

class FarmAPIController extends AppBaseController
{
    /** @var  FarmRepository */
    private $farmRepository;

    public function __construct(FarmRepository $farmRepo)
    {
        $this->farmRepository = $farmRepo;
    }

    /**
     * Display a listing of the Farm.
     * GET|HEAD /farms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $farms = Farm::with('user')->get();
        $response = [
            'success'=>true,
            'data'=> $farms,
            'message'=> 'farms retrieved successfully'
         ];
         return response()->json($response,200);
    }

    /**
     * Store a newly created Farm in storage.
     * POST /farms
     *
     * @param CreateFarmAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
           //existing farm
           $existing_farm = Farm::where('name',$request->input('name'))->first();
           $rules = [
            'name'=> 'required|unique:farms',
           'address' => 'required|string',
           'field_area' => 'required|integer',
           'latitude' => 'required|string',
           'longitude' =>'required|string',
           'size_unit' => 'required|string',
           'image' => 'nullable'];

           $request->validate($rules);
           if(!$existing_farm){
               $farm = new farm();
               $farm->name = $request->name;
               $farm->address = $request->address;
               $farm->field_area = $request->field_area;
               $farm->latitude = $request->latitude;
               $farm->longitude = (int)$request->longitude;
               $farm->size_unit = $request->size_unit;
               $farm->image = $request->image;
               $farm->user_id = auth()->user()->id;

                $farm->save();

                $success['name'] = $farm->name;
                $success['address'] = $farm->address;
                $success['field_area'] = $farm->field_area;
                $success['size_unit'] = $farm->size_unit;
                $success['latitude'] = $farm->latitude;
                $success['longitude'] = $farm->longitude;
                $success['farm_owner'] = $farm->user;
                $success['image'] = $farm->image;
                $success['created_at'] = $farm->created_at;

                $farm = Farm::find($farm->id);

                $farm->image = \App\Models\ImageUploader::upload($request->file('image'),'farms');
                $farm->save();
                $response = [
                   'success'=>true,
                   'data'=> $success,
                   'message'=> 'Farm created successfully'
                ];

           return response()->json($response,200);

           }
           else{
               $response = [
                   'success'=>false,
                   'message'=> 'Farm name already exists'
                ];
                return response()->json($response,403);
           }
    }

    /**
     * Display the specified Farm.
     * GET|HEAD /farms/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $farm = Farm::find($id);
        $success['name'] = $farm->name;
        $success['address'] = $farm->address;
        $success['field_area'] = $farm->field_area;
        $success['size_unit'] = $farm->size_unit;
        $success['latitude'] = $farm->latitude;
        $success['longitude'] = $farm->longitude;
        $success['plots'] = $farm->plots;
        $success['farm_owner'] = $farm->user;
        $success['image'] = $farm->image;
        $success['created_at'] = $farm->created_at;

        if (empty($farm)) {
            return $this->sendError('Farm not found');
        }
        $response = [
            'success'=>true,
            'data'=> $success,
            'message'=> 'Farm data retrieved successfully'
           ];

        return response()->json($response,200);
    }

    //get farms belonging to a farmer
    public function farmUser(Request $request)
    {


        $farmer = User::where('id',auth()->user()->id)->first();
        //dd($farmer);

        if (empty($farmer->farms)) {
            return $this->sendError('Farmer has no farms');
        }
        else{
            $success['farm-owner'] = $farmer;
            $success['farms'] = $farmer->farms;


            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'User farms  retrieved successfully'
               ];
               return response()->json($response,200);
        }


    }

    /**
     * Update the specified Farm in storage.
     * PUT/PATCH /farms/{id}
     *
     * @param int $id
     * @param UpdateFarmAPIRequest $request
     *
     * @return Response
     */
    public function update($id,Request $request)
    {
        $input = $request->all();

        /** @var Farm $farm */
        $farm = $this->farmRepository->find($id);

        if (empty($farm)) {
            return $this->sendError('Farm not found');
        }

        $farm = $this->farmRepository->update($input, $id);

        return $this->sendResponse($farm->toArray(), 'Farm updated successfully');
    }

    /**
     * Remove the specified Farm from storage.
     * DELETE /farms/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Farm $farm */
        $farm = $this->farmRepository->find($id);

        if (empty($farm)) {
            return $this->sendError('Farm not found');
        }

        $farm->delete();

        return $this->sendSuccess('Farm deleted successfully');
    }
}
