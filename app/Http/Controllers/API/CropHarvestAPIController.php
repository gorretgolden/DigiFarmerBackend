<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCropHarvestAPIRequest;
use App\Http\Requests\API\UpdateCropHarvestAPIRequest;
use App\Models\CropHarvest;
use App\Repositories\CropHarvestRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Plot;

/**
 * Class CropHarvestController
 * @package App\Http\Controllers\API
 */

class CropHarvestAPIController extends AppBaseController
{
    /** @var  CropHarvestRepository */
    private $cropHarvestRepository;

    public function __construct(CropHarvestRepository $cropHarvestRepo)
    {
        $this->cropHarvestRepository = $cropHarvestRepo;
    }

    /**
     * Display a listing of the CropHarvest.
     * GET|HEAD /cropHarvests
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $cropHarvests = $this->cropHarvestRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($cropHarvests->toArray(), 'Crop Harvests retrieved successfully');
    }

    /**
     * Store a newly created CropHarvest in storage.
     * POST /cropHarvests
     *
     * @param CreateCropHarvestAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCropHarvestAPIRequest $request)
    {

        $input = $request->all();
        $cropHarvest = $this->cropHarvestRepository->create($input);

        $plot = Plot::find($request->plot_id);

        return $this->sendResponse($cropHarvest->toArray(), 'Crop Harvest saved successfully');

    }




    /**
     * Display the specified CropHarvest.
     * GET|HEAD /cropHarvests/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Plot $plot */
        $cropHarvest = CropHarvest::find($id);


        if (empty($cropHarvest)) {
            return $this->sendError('Crop Harvest not found');
        }
        else{
            $success['quantity'] = $cropHarvest->quantity;
            $success['quantity_unit'] = $cropHarvest->quantity_unit;
            $success['plot'] = $cropHarvest->plot;
            $success['created_at'] = $cropHarvest->created_at;


            $response = [
                'success'=>true,
                'data'=>[
                    'success'=>$success
                ],
                'message'=> 'Crop Harvest details retrieved successfully'
             ];

             return response()->json($response,200);
            }
    }

    /**
     * Update the specified CropHarvest in storage.
     * PUT/PATCH /cropHarvests/{id}
     *
     * @param int $id
     * @param UpdateCropHarvestAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropHarvestAPIRequest $request)
    {
        $input = $request->all();

        /** @var CropHarvest $cropHarvest */
        $cropHarvest = $this->cropHarvestRepository->find($id);

        if (empty($cropHarvest)) {
            return $this->sendError('Crop Harvest not found');
        }

        $cropHarvest = $this->cropHarvestRepository->update($input, $id);

        return $this->sendResponse($cropHarvest->toArray(), 'CropHarvest updated successfully');
    }

    /**
     * Remove the specified CropHarvest from storage.
     * DELETE /cropHarvests/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CropHarvest $cropHarvest */
        $cropHarvest = $this->cropHarvestRepository->find($id);

        if (empty($cropHarvest)) {
            return $this->sendError('Crop Harvest not found');
        }

        $cropHarvest->delete();

        return $this->sendSuccess('Crop Harvest deleted successfully');
    }
}
