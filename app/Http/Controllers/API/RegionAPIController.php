<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRegionAPIRequest;
use App\Http\Requests\API\UpdateRegionAPIRequest;
use App\Models\Region;
use App\Repositories\RegionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use DB;

/**
 * Class RegionController
 * @package App\Http\Controllers\API
 */

class RegionAPIController extends AppBaseController
{
    /** @var  RegionRepository */
    private $regionRepository;

    public function __construct(RegionRepository $regionRepo)
    {
        $this->regionRepository = $regionRepo;
    }

    /**
     * Display a listing of the Region.
     * GET|HEAD /regions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $regions = Region::where('is_active',1)->get(['id','name']);
        return $this->sendResponse($regions->toArray(), 'Regions retrieved successfully');
    }


    //get districts in a region
    public function region_districts(Request $request, $id)
    {
        $region = Region::find($id);

        $districts = DB::table('regions')
        ->join('districts', 'districts.region_id', '=','regions.id')
        ->where('regions.id', '=', $region->id)
        ->select('districts.id','districts.name')
        ->orderBy('districts.name','ASC')
        ->get();




        if (empty($region)) {
            $response = [
                'success'=>false,
                'message'=> 'Region not found'
              ];
             return response()->json($response,404);

        }elseif(count($districts) == 0){

            $response = [
                'success'=>false,
                'message'=> 'Region has no districts'
              ];
             return response()->json($response,404);

        }
        else{


            $response = [
                'success'=>true,
                'data'=>$districts,
                'message'=> 'Region  districts retrieved'
              ];
             return response()->json($response,200);


        }


    }

    /**
     * Store a newly created Region in storage.
     * POST /regions
     *
     * @param CreateRegionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRegionAPIRequest $request)
    {
        $input = $request->all();

        $region = $this->regionRepository->create($input);

        return $this->sendResponse($region->toArray(), 'Region saved successfully');
    }

    /**
     * Display the specified Region.
     * GET|HEAD /regions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Region $region */
        $region = $this->regionRepository->find($id);

        if (empty($region)) {
            return $this->sendError('Region not found');
        }

        return $this->sendResponse($region->toArray(), 'Region retrieved successfully');
    }

    /**
     * Update the specified Region in storage.
     * PUT/PATCH /regions/{id}
     *
     * @param int $id
     * @param UpdateRegionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Region $region */
        $region = $this->regionRepository->find($id);

        if (empty($region)) {
            return $this->sendError('Region not found');
        }

        $region = $this->regionRepository->update($input, $id);

        return $this->sendResponse($region->toArray(), 'Region updated successfully');
    }

    /**
     * Remove the specified Region from storage.
     * DELETE /regions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Region $region */
        $region = $this->regionRepository->find($id);

        if (empty($region)) {
            return $this->sendError('Region not found');
        }

        $region->delete();

        return $this->sendSuccess('Region deleted successfully');
    }
}
