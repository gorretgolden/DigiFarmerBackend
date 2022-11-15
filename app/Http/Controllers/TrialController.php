<?php

namespace App\Http\Controllers;

use App\DataTables\TrialDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTrialRequest;
use App\Http\Requests\UpdateTrialRequest;
use App\Repositories\TrialRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class TrialController extends AppBaseController
{
    /** @var TrialRepository $trialRepository*/
    private $trialRepository;

    public function __construct(TrialRepository $trialRepo)
    {
        $this->trialRepository = $trialRepo;
    }

    /**
     * Display a listing of the Trial.
     *
     * @param TrialDataTable $trialDataTable
     *
     * @return Response
     */
    public function index(TrialDataTable $trialDataTable)
    {
        return $trialDataTable->render('trials.index');
    }

    /**
     * Show the form for creating a new Trial.
     *
     * @return Response
     */
    public function create()
    {
        return view('trials.create');
    }

    /**
     * Store a newly created Trial in storage.
     *
     * @param CreateTrialRequest $request
     *
     * @return Response
     */
    public function store(CreateTrialRequest $request)
    {
        $input = $request->all();

        $trial = $this->trialRepository->create($input);

        Flash::success('Trial saved successfully.');

        return redirect(route('trials.index'));
    }

    /**
     * Display the specified Trial.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $trial = $this->trialRepository->find($id);

        if (empty($trial)) {
            Flash::error('Trial not found');

            return redirect(route('trials.index'));
        }

        return view('trials.show')->with('trial', $trial);
    }

    /**
     * Show the form for editing the specified Trial.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $trial = $this->trialRepository->find($id);

        if (empty($trial)) {
            Flash::error('Trial not found');

            return redirect(route('trials.index'));
        }

        return view('trials.edit')->with('trial', $trial);
    }

    /**
     * Update the specified Trial in storage.
     *
     * @param int $id
     * @param UpdateTrialRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTrialRequest $request)
    {
        $trial = $this->trialRepository->find($id);

        if (empty($trial)) {
            Flash::error('Trial not found');

            return redirect(route('trials.index'));
        }

        $trial = $this->trialRepository->update($request->all(), $id);

        Flash::success('Trial updated successfully.');

        return redirect(route('trials.index'));
    }

    /**
     * Remove the specified Trial from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $trial = $this->trialRepository->find($id);

        if (empty($trial)) {
            Flash::error('Trial not found');

            return redirect(route('trials.index'));
        }

        $this->trialRepository->delete($id);

        Flash::success('Trial deleted successfully.');

        return redirect(route('trials.index'));
    }
}
