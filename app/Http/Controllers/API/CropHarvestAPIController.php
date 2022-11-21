<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCropHarvestAPIRequest;
use App\Http\Requests\API\UpdateCropHarvestAPIRequest;
use App\Models\CropHarvest;
use App\Repositories\CropHarvestRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

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
        //$existing_harvest = CropHarvest::where('plot_id',$request->plot_id)->first();


        $cropHarvest = $this->cropHarvestRepository->create($input);

        return $this->sendResponse($cropHarvest->toArray(), 'Crop Harvest saved successfully');

    }

    public function getTotalHarvestForPlot(Request $request,$id)
    {

        $totalPlotHarvest =  CropHarvest::where('plot_id',$id)->sum('quantity');

        $response = [
            'success'=>true,
            'data'=> [
                'total-harvest'=> $totalPlotHarvest,
                'harvest-unit' => 'kg'
            ],
            'message'=> 'Total plot harvest retrieved'
         ];

         return response()->json($response,200);

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
        /** @var CropHarvest $cropHarvest */
        $cropHarvest = $this->cropHarvestRepository->find($id);

        if (empty($cropHarvest)) {
            return $this->sendError('Crop Harvest not found');
        }

        return $this->sendResponse($cropHarvest->toArray(), 'Crop Harvest retrieved successfully');
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
