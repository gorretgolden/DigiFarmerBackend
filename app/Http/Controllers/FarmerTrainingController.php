<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFarmerTrainingRequest;
use App\Http\Requests\UpdateFarmerTrainingRequest;
use App\Repositories\FarmerTrainingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class FarmerTrainingController extends AppBaseController
{
    /** @var FarmerTrainingRepository $farmerTrainingRepository*/
    private $farmerTrainingRepository;

    public function __construct(FarmerTrainingRepository $farmerTrainingRepo)
    {
        $this->farmerTrainingRepository = $farmerTrainingRepo;
    }

    /**
     * Display a listing of the FarmerTraining.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $farmerTrainings = $this->farmerTrainingRepository->all();

        return view('farmer_trainings.index')
            ->with('farmerTrainings', $farmerTrainings);
    }

    /**
     * Show the form for creating a new FarmerTraining.
     *
     * @return Response
     */
    public function create()
    {
        return view('farmer_trainings.create');
    }

    /**
     * Store a newly created FarmerTraining in storage.
     *
     * @param CreateFarmerTrainingRequest $request
     *
     * @return Response
     */
    public function store(CreateFarmerTrainingRequest $request)
    {
        $input = $request->all();

        $farmerTraining = $this->farmerTrainingRepository->create($input);

        Flash::success('Farmer Training saved successfully.');

        return redirect(route('farmerTrainings.index'));
    }

    /**
     * Display the specified FarmerTraining.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $farmerTraining = $this->farmerTrainingRepository->find($id);

        if (empty($farmerTraining)) {
            Flash::error('Farmer Training not found');

            return redirect(route('farmerTrainings.index'));
        }

        return view('farmer_trainings.show')->with('farmerTraining', $farmerTraining);
    }

    /**
     * Show the form for editing the specified FarmerTraining.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $farmerTraining = $this->farmerTrainingRepository->find($id);

        if (empty($farmerTraining)) {
            Flash::error('Farmer Training not found');

            return redirect(route('farmerTrainings.index'));
        }

        return view('farmer_trainings.edit')->with('farmerTraining', $farmerTraining);
    }

    /**
     * Update the specified FarmerTraining in storage.
     *
     * @param int $id
     * @param UpdateFarmerTrainingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFarmerTrainingRequest $request)
    {
        $farmerTraining = $this->farmerTrainingRepository->find($id);

        if (empty($farmerTraining)) {
            Flash::error('Farmer Training not found');

            return redirect(route('farmerTrainings.index'));
        }

        $farmerTraining = $this->farmerTrainingRepository->update($request->all(), $id);

        Flash::success('Farmer Training updated successfully.');

        return redirect(route('farmerTrainings.index'));
    }

    /**
     * Remove the specified FarmerTraining from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $farmerTraining = $this->farmerTrainingRepository->find($id);

        if (empty($farmerTraining)) {
            Flash::error('Farmer Training not found');

            return redirect(route('farmerTrainings.index'));
        }

        $this->farmerTrainingRepository->delete($id);

        Flash::success('Farmer Training deleted successfully.');

        return redirect(route('farmerTrainings.index'));
    }
}
