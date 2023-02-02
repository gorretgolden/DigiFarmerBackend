<?php

namespace App\Http\Controllers;

use App\DataTables\CropHarvestDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCropHarvestRequest;
use App\Http\Requests\UpdateCropHarvestRequest;
use App\Repositories\CropHarvestRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CropHarvest;
use App\Models\Plot;

class CropHarvestController extends AppBaseController
{
    /** @var CropHarvestRepository $cropHarvestRepository*/
    private $cropHarvestRepository;

    public function __construct(CropHarvestRepository $cropHarvestRepo)
    {
        $this->cropHarvestRepository = $cropHarvestRepo;
    }

    /**
     * Display a listing of the CropHarvest.
     *
     * @param CropHarvestDataTable $cropHarvestDataTable
     *
     * @return Response
     */
    public function index(CropHarvestDataTable $cropHarvestDataTable)
    {
        return $cropHarvestDataTable->render('crop_harvests.index');
    }

    /**
     * Show the form for creating a new CropHarvest.
     *
     * @return Response
     */
    public function create()
    {
        return view('crop_harvests.create');
    }

    /**
     * Store a newly created CropHarvest in storage.
     *
     * @param CreateCropHarvestRequest $request
     *
     * @return Response
     */
    public function store(CreateCropHarvestRequest $request)
    {
        $input = $request->all();
        $input['quantity_unit'] = 'kg';

        $cropHarvest = $this->cropHarvestRepository->create($input);
        $totalPlotHarvest =  CropHarvest::where('plot_id',$request->plot_id)->sum('quantity');

        // $plot = Plot::find($request->plot_id);

        // $plot->total_harvest =  $totalPlotHarvest;
        // $plot->save();

        Flash::success('Crop Harvest saved successfully.');

        return redirect(route('cropHarvests.index'));
    }

    /**
     * Display the specified CropHarvest.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cropHarvest = $this->cropHarvestRepository->find($id);

        if (empty($cropHarvest)) {
            Flash::error('Crop Harvest not found');

            return redirect(route('cropHarvests.index'));
        }

        return view('crop_harvests.show')->with('cropHarvest', $cropHarvest);
    }

    /**
     * Show the form for editing the specified CropHarvest.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cropHarvest = $this->cropHarvestRepository->find($id);

        if (empty($cropHarvest)) {
            Flash::error('Crop Harvest not found');

            return redirect(route('cropHarvests.index'));
        }

        return view('crop_harvests.edit')->with('cropHarvest', $cropHarvest);
    }

    /**
     * Update the specified CropHarvest in storage.
     *
     * @param int $id
     * @param UpdateCropHarvestRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropHarvestRequest $request)
    {
        $cropHarvest = $this->cropHarvestRepository->find($id);

        if (empty($cropHarvest)) {
            Flash::error('Crop Harvest not found');

            return redirect(route('cropHarvests.index'));
        }

        $cropHarvest = $this->cropHarvestRepository->update($request->all(), $id);

        Flash::success('Crop Harvest updated successfully.');

        return redirect(route('cropHarvests.index'));
    }

    /**
     * Remove the specified CropHarvest from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cropHarvest = $this->cropHarvestRepository->find($id);

        if (empty($cropHarvest)) {
            Flash::error('Crop Harvest not found');

            return redirect(route('cropHarvests.index'));
        }
        $cropHarvest->plot->total_harvest = 0;
        $cropHarvest->update();

        $this->cropHarvestRepository->delete($id);

        Flash::success('Crop Harvest deleted successfully.');

        return redirect(route('cropHarvests.index'));
    }
}
