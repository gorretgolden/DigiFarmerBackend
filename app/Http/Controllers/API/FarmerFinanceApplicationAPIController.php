<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFarmerFinanceApplicationAPIRequest;
use App\Http\Requests\API\UpdateFarmerFinanceApplicationAPIRequest;
use App\Models\FarmerFinanceApplication;
use App\Repositories\FarmerFinanceApplicationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FarmerFinanceApplicationController
 * @package App\Http\Controllers\API
 */

class FarmerFinanceApplicationAPIController extends AppBaseController
{
    /** @var  FarmerFinanceApplicationRepository */
    private $farmerFinanceApplicationRepository;

    public function __construct(FarmerFinanceApplicationRepository $farmerFinanceApplicationRepo)
    {
        $this->farmerFinanceApplicationRepository = $farmerFinanceApplicationRepo;
    }

    /**
     * Display a listing of the FarmerFinanceApplication.
     * GET|HEAD /farmerFinanceApplications
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $farmerFinanceApplications = $this->farmerFinanceApplicationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($farmerFinanceApplications->toArray(), 'Farmer Finance Applications retrieved successfully');
    }

    /**
     * Store a newly created FarmerFinanceApplication in storage.
     * POST /farmerFinanceApplications
     *
     * @param CreateFarmerFinanceApplicationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFarmerFinanceApplicationAPIRequest $request)
    {
        $input = $request->all();

        $farmerFinanceApplication = $this->farmerFinanceApplicationRepository->create($input);

        return $this->sendResponse($farmerFinanceApplication->toArray(), 'Farmer Finance Application saved successfully');
    }

    /**
     * Display the specified FarmerFinanceApplication.
     * GET|HEAD /farmerFinanceApplications/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FarmerFinanceApplication $farmerFinanceApplication */
        $farmerFinanceApplication = $this->farmerFinanceApplicationRepository->find($id);

        if (empty($farmerFinanceApplication)) {
            return $this->sendError('Farmer Finance Application not found');
        }

        return $this->sendResponse($farmerFinanceApplication->toArray(), 'Farmer Finance Application retrieved successfully');
    }

    /**
     * Update the specified FarmerFinanceApplication in storage.
     * PUT/PATCH /farmerFinanceApplications/{id}
     *
     * @param int $id
     * @param UpdateFarmerFinanceApplicationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFarmerFinanceApplicationAPIRequest $request)
    {
        $input = $request->all();

        /** @var FarmerFinanceApplication $farmerFinanceApplication */
        $farmerFinanceApplication = $this->farmerFinanceApplicationRepository->find($id);

        if (empty($farmerFinanceApplication)) {
            return $this->sendError('Farmer Finance Application not found');
        }

        $farmerFinanceApplication = $this->farmerFinanceApplicationRepository->update($input, $id);

        return $this->sendResponse($farmerFinanceApplication->toArray(), 'FarmerFinanceApplication updated successfully');
    }

    /**
     * Remove the specified FarmerFinanceApplication from storage.
     * DELETE /farmerFinanceApplications/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FarmerFinanceApplication $farmerFinanceApplication */
        $farmerFinanceApplication = $this->farmerFinanceApplicationRepository->find($id);

        if (empty($farmerFinanceApplication)) {
            return $this->sendError('Farmer Finance Application not found');
        }

        $farmerFinanceApplication->delete();

        return $this->sendSuccess('Farmer Finance Application deleted successfully');
    }
}
