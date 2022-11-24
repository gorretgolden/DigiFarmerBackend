<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFarmerTrainingAPIRequest;
use App\Http\Requests\API\UpdateFarmerTrainingAPIRequest;
use App\Models\FarmerTraining;
use App\Repositories\FarmerTrainingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FarmerTrainingController
 * @package App\Http\Controllers\API
 */

class FarmerTrainingAPIController extends AppBaseController
{
    /** @var  FarmerTrainingRepository */
    private $farmerTrainingRepository;

    public function __construct(FarmerTrainingRepository $farmerTrainingRepo)
    {
        $this->farmerTrainingRepository = $farmerTrainingRepo;
    }

    /**
     * Display a listing of the FarmerTraining.
     * GET|HEAD /farmerTrainings
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $farmerTrainings = $this->farmerTrainingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($farmerTrainings->toArray(), 'Farmer Trainings retrieved successfully');
    }

    /**
     * Store a newly created FarmerTraining in storage.
     * POST /farmerTrainings
     *
     * @param CreateFarmerTrainingAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFarmerTrainingAPIRequest $request)
    {
        $input = $request->all();

        $farmerTraining = $this->farmerTrainingRepository->create($input);

        return $this->sendResponse($farmerTraining->toArray(), 'Farmer Training saved successfully');
    }

    /**
     * Display the specified FarmerTraining.
     * GET|HEAD /farmerTrainings/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FarmerTraining $farmerTraining */
        $farmerTraining = $this->farmerTrainingRepository->find($id);

        if (empty($farmerTraining)) {
            return $this->sendError('Farmer Training not found');
        }

        return $this->sendResponse($farmerTraining->toArray(), 'Farmer Training retrieved successfully');
    }

    /**
     * Update the specified FarmerTraining in storage.
     * PUT/PATCH /farmerTrainings/{id}
     *
     * @param int $id
     * @param UpdateFarmerTrainingAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFarmerTrainingAPIRequest $request)
    {
        $input = $request->all();

        /** @var FarmerTraining $farmerTraining */
        $farmerTraining = $this->farmerTrainingRepository->find($id);

        if (empty($farmerTraining)) {
            return $this->sendError('Farmer Training not found');
        }

        $farmerTraining = $this->farmerTrainingRepository->update($input, $id);

        return $this->sendResponse($farmerTraining->toArray(), 'FarmerTraining updated successfully');
    }

    /**
     * Remove the specified FarmerTraining from storage.
     * DELETE /farmerTrainings/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FarmerTraining $farmerTraining */
        $farmerTraining = $this->farmerTrainingRepository->find($id);

        if (empty($farmerTraining)) {
            return $this->sendError('Farmer Training not found');
        }

        $farmerTraining->delete();

        return $this->sendSuccess('Farmer Training deleted successfully');
    }
}
