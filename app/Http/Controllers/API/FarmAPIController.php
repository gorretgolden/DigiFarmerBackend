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
        $farms = $this->farmRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($farms->toArray(), 'Farms retrieved successfully');
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
           $validator = Validator::make($request->all(),[
            'name'=> 'required|unique:farms',
            'address' => 'required|string',
            'field_size' => 'required|integer',
            'latitude' => 'required|string',
            'longitude' =>'required|string',
            'size_unit' => 'required|string',
            'image' => 'nullable'

           ]);
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
                $success['field_size'] = $farm->field_size;
                $success['size_unit'] = $farm->size_unit;
                $success['latitude'] = $farm->latitude;
                $success['longitude'] = $farm->longitude;
                $success['farm_owner'] = $farm->user->email;
                $success['image'] = $farm->image;

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
        /** @var Farm $farm */
        $farm = $this->farmRepository->find($id);

        if (empty($farm)) {
            return $this->sendError('Farm not found');
        }

        return $this->sendResponse($farm->toArray(), 'Farm retrieved successfully');
    }

    //get farms belonging to a farmer
    public function farmUser(Request $request)
    {
        /** @var Farm $farm */
        $user_id = auth()->user()->id();
        dd($user_id);
        $farm_user = Farm::where('user_id',$user_id)->first();

        if (empty($farm_user)) {
            return $this->sendError('Farmer has no farms');
        }
        else{
            $success['farm_owner'] = $farm_user->user->name;
            $success['name'] = $farm_user->name;
            $success['address'] = $farm_user->address;
            $success['field_area'] = $farm_user->field_area;
            $success['size_unit'] = $farm_user->size_unit;
            $success['image'] = $farm_user->image;

            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'User farm details retrieved successfully'
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
    public function update($id, UpdateFarmAPIRequest $request)
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
