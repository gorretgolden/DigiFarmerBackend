<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTrainingVendorServiceAPIRequest;
use App\Http\Requests\API\UpdateTrainingVendorServiceAPIRequest;
use App\Models\TrainingVendorService;
use App\Repositories\TrainingVendorServiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class TrainingVendorServiceController
 * @package App\Http\Controllers\API
 */

class TrainingVendorServiceAPIController extends AppBaseController
{
    /** @var  TrainingVendorServiceRepository */
    private $trainingVendorServiceRepository;

    public function __construct(TrainingVendorServiceRepository $trainingVendorServiceRepo)
    {
        $this->trainingVendorServiceRepository = $trainingVendorServiceRepo;
    }

    /**
     * Display a listing of the TrainingVendorService.
     * GET|HEAD /trainingVendorServices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $trainingVendorServices = $this->trainingVendorServiceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($trainingVendorServices->toArray(), 'Training Vendor Services retrieved successfully');
    }

    /**
     * Store a newly created TrainingVendorService in storage.
     * POST /trainingVendorServices
     *
     * @param CreateTrainingVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTrainingVendorServiceAPIRequest $request)
    {
        $input = $request->all();

        $trainingVendorService = $this->trainingVendorServiceRepository->create($input);

        return $this->sendResponse($trainingVendorService->toArray(), 'Training Vendor Service saved successfully');
    }

    /**
     * Display the specified TrainingVendorService.
     * GET|HEAD /trainingVendorServices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var TrainingVendorService $trainingVendorService */
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            return $this->sendError('Training Vendor Service not found');
        }

        return $this->sendResponse($trainingVendorService->toArray(), 'Training Vendor Service retrieved successfully');
    }

    /**
     * Update the specified TrainingVendorService in storage.
     * PUT/PATCH /trainingVendorServices/{id}
     *
     * @param int $id
     * @param UpdateTrainingVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTrainingVendorServiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var TrainingVendorService $trainingVendorService */
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            return $this->sendError('Training Vendor Service not found');
        }

        $trainingVendorService = $this->trainingVendorServiceRepository->update($input, $id);

        return $this->sendResponse($trainingVendorService->toArray(), 'TrainingVendorService updated successfully');
    }

    /**
     * Remove the specified TrainingVendorService from storage.
     * DELETE /trainingVendorServices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var TrainingVendorService $trainingVendorService */
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            return $this->sendError('Training Vendor Service not found');
        }

        $trainingVendorService->delete();

        return $this->sendSuccess('Training Vendor Service deleted successfully');
    }
}
