<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFarmAPIRequest;
use App\Http\Requests\API\UpdateFarmAPIRequest;
use App\Models\Farm;
use App\Repositories\FarmRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

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


    //farms for a logged in farmer
    public function userFarms(Request $request){
        $farmerFarms = Farm::with('address')->where('owner',auth()->user()->username)->get();
        //dd($farmerFarms->toArray());
        $total_farms = $farmerFarms->count();
        if($total_farms == 0){

            $response = [
                'success'=>true,
                'message'=> 'Farmer has no farms'
             ];
             return response()->json($response,200);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-farms'=>$total_farms,
                     'farms' =>$farmerFarms->toArray(),
                ],
                'message'=> 'User farms retrieved successfully'
             ];
             return response()->json($response,200);


        }

    }


    //get particular farm plots
     //tasks on plot
     public function farm_plots(Request $request,$id)
     {

         $farm = Farm::find($id);
         if (empty($farm)) {
             return $this->sendError('farm not found');
         }
         $success = $farm->plots;

         if($farm->plots->count()==0){
             $response = [
                 'success'=>false,
                 'message'=> 'farm has no plots'
              ];
              return response()->json($response,404);

         }else{
             $response = [
                 'success'=>true,
                 'data'=>[
                    'total' =>$farm->plots->count(),
                     'plots'=>$success

                 ],
                 'message'=> 'farm plots retrieved successfully '
              ];

              return response()->json($response,200);

         }


     }

    public function store(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:20|unique:farms,id',
            'field_area' => 'required',
            'size_unit' => 'nullable|string',
            'address_id' => 'required|integer'
        ];
        $request->validate($rules);
        if(Farm::where('name',$request->name)->where('owner',auth()->user()->username)->first()){
            $response = [
                'success'=>false,
                'message'=> 'The farm name already exists'
             ];
             return response()->json($response,409);
        }else{
            $farm = new Farm();
            $farm->owner = auth()->user()->username;
            $farm->name = $request->name;
            $farm->address_id = $request->address_id;
            $farm->field_area = $request->field_area;

            $farm->save();

            return $this->sendResponse($farm->toArray(), 'Farm saved successfully');

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
        }else{
            $success['name'] = $farm->name;
            $success['owner'] = $farm->owner;
            $success['field_area'] = $farm->field_area." ".$farm->size_unit;
            $success['location'] = $farm->address->district_nam;
            $success['created_at'] = $farm->created_at->format('d/m/Y');
        }
        $response = [
            'success'=>true,
            'data'=> $success,
            'message'=> 'Farm retrieved successfully'
         ];

         return response()->json($response,200);



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
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var Farm $farm */
        $farm = $this->farmRepository->find($id);

        if (empty($farm)) {
            return $this->sendError('Farm not found');
        }

        $rules = [
            'name' => 'required|string',
            'field_area' => 'required|integer'

        ];
        $request->validate($rules);

        $farm->name = $request->name;
        $farm->field_area = $request->field_area;
        $farm->owner = auth()->user()->username;
        $farm->save();

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
