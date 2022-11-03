<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHarvestRequest;
use App\Http\Requests\UpdateHarvestRequest;
use App\Repositories\HarvestRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class HarvestController extends AppBaseController
{
    /** @var HarvestRepository $harvestRepository*/
    private $harvestRepository;

    public function __construct(HarvestRepository $harvestRepo)
    {
        $this->harvestRepository = $harvestRepo;
    }

    /**
     * Display a listing of the Harvest.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $harvests = $this->harvestRepository->all();

        return view('harvests.index')
            ->with('harvests', $harvests);
    }

    /**
     * Show the form for creating a new Harvest.
     *
     * @return Response
     */
    public function create()
    {
        return view('harvests.create');
    }

    /**
     * Store a newly created Harvest in storage.
     *
     * @param CreateHarvestRequest $request
     *
     * @return Response
     */
    public function store(CreateHarvestRequest $request)
    {
        $input = $request->all();

        $harvest = $this->harvestRepository->create($input);

        Flash::success('Harvest saved successfully.');

        return redirect(route('harvests.index'));
    }

    /**
     * Display the specified Harvest.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $harvest = $this->harvestRepository->find($id);

        if (empty($harvest)) {
            Flash::error('Harvest not found');

            return redirect(route('harvests.index'));
        }

        return view('harvests.show')->with('harvest', $harvest);
    }

    /**
     * Show the form for editing the specified Harvest.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $harvest = $this->harvestRepository->find($id);

        if (empty($harvest)) {
            Flash::error('Harvest not found');

            return redirect(route('harvests.index'));
        }

        return view('harvests.edit')->with('harvest', $harvest);
    }

    /**
     * Update the specified Harvest in storage.
     *
     * @param int $id
     * @param UpdateHarvestRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHarvestRequest $request)
    {
        $harvest = $this->harvestRepository->find($id);

        if (empty($harvest)) {
            Flash::error('Harvest not found');

            return redirect(route('harvests.index'));
        }

        $harvest = $this->harvestRepository->update($request->all(), $id);

        Flash::success('Harvest updated successfully.');

        return redirect(route('harvests.index'));
    }

    /**
     * Remove the specified Harvest from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $harvest = $this->harvestRepository->find($id);

        if (empty($harvest)) {
            Flash::error('Harvest not found');

            return redirect(route('harvests.index'));
        }

        $this->harvestRepository->delete($id);

        Flash::success('Harvest deleted successfully.');

        return redirect(route('harvests.index'));
    }
}
