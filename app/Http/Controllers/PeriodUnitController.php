<?php

namespace App\Http\Controllers;

use App\DataTables\PeriodUnitDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePeriodUnitRequest;
use App\Http\Requests\UpdatePeriodUnitRequest;
use App\Repositories\PeriodUnitRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PeriodUnitController extends AppBaseController
{
    /** @var PeriodUnitRepository $periodUnitRepository*/
    private $periodUnitRepository;

    public function __construct(PeriodUnitRepository $periodUnitRepo)
    {
        $this->periodUnitRepository = $periodUnitRepo;
    }

    /**
     * Display a listing of the PeriodUnit.
     *
     * @param PeriodUnitDataTable $periodUnitDataTable
     *
     * @return Response
     */
    public function index(PeriodUnitDataTable $periodUnitDataTable)
    {
        return $periodUnitDataTable->render('period_units.index');
    }

    /**
     * Show the form for creating a new PeriodUnit.
     *
     * @return Response
     */
    public function create()
    {
        return view('period_units.create');
    }

    /**
     * Store a newly created PeriodUnit in storage.
     *
     * @param CreatePeriodUnitRequest $request
     *
     * @return Response
     */
    public function store(CreatePeriodUnitRequest $request)
    {
        $input = $request->all();

        $periodUnit = $this->periodUnitRepository->create($input);

        Flash::success('Period Unit saved successfully.');

        return redirect(route('periodUnits.index'));
    }

    /**
     * Display the specified PeriodUnit.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $periodUnit = $this->periodUnitRepository->find($id);

        if (empty($periodUnit)) {
            Flash::error('Period Unit not found');

            return redirect(route('periodUnits.index'));
        }

        return view('period_units.show')->with('periodUnit', $periodUnit);
    }

    /**
     * Show the form for editing the specified PeriodUnit.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $periodUnit = $this->periodUnitRepository->find($id);

        if (empty($periodUnit)) {
            Flash::error('Period Unit not found');

            return redirect(route('periodUnits.index'));
        }

        return view('period_units.edit')->with('periodUnit', $periodUnit);
    }

    /**
     * Update the specified PeriodUnit in storage.
     *
     * @param int $id
     * @param UpdatePeriodUnitRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePeriodUnitRequest $request)
    {
        $periodUnit = $this->periodUnitRepository->find($id);

        if (empty($periodUnit)) {
            Flash::error('Period Unit not found');

            return redirect(route('periodUnits.index'));
        }

        $periodUnit = $this->periodUnitRepository->update($request->all(), $id);

        Flash::success('Period Unit updated successfully.');

        return redirect(route('periodUnits.index'));
    }

    /**
     * Remove the specified PeriodUnit from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $periodUnit = $this->periodUnitRepository->find($id);

        if (empty($periodUnit)) {
            Flash::error('Period Unit not found');

            return redirect(route('periodUnits.index'));
        }

        $this->periodUnitRepository->delete($id);

        Flash::success('Period Unit deleted successfully.');

        return redirect(route('periodUnits.index'));
    }
}
