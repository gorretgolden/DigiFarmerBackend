<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFarmAPIRequest;
use App\Http\Requests\API\UpdateFarmAPIRequest;
use App\Models\Farm;
use App\Repositories\FarmRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FarmController
 * @package App\Http\Controllers\API
 */

class FarmAPIController extends AppBaseController
{
    /** @var  FarmRepository */
    private $farmRepository;

    public function __construct(FarmRepository $farmRepo)
    {
        $this->farmRepository = $farmRepo;
    }

    /**
     * Display a listing of the Farm.
     * GET|HEAD /farms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $farms = $this->farmRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($farms->toArray(), 'Farms retrieved successfully');
    }

    /**
     * Store a newly created Farm in storage.
     * POST /farms
     *
     * @param CreateFarmAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFarmAPIRequest $request)
    {
        $input = $request->all();

        $farm = $this->farmRepository->create($input);

        return $this->sendResponse($farm->toArray(), 'Farm saved successfully');
    }

    /**
     * Display the specified Farm.
     * GET|HEAD /farms/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Farm $farm */
        $farm = $this->farmRepository->find($id);

        if (empty($farm)) {
            return $this->sendError('Farm not found');
        }

        return $this->sendResponse($farm->toArray(), 'Farm retrieved successfully');
    }

    /**
     * Update the specified Farm in storage.
     * PUT/PATCH /farms/{id}
     *
     * @param int $id
     * @param UpdateFarmAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFarmAPIRequest $request)
    {
        $input = $request->all();

        /** @var Farm $farm */
        $farm = $this->farmRepository->find($id);

        if (empty($farm)) {
            return $this->sendError('Farm not found');
        }

        $farm = $this->farmRepository->update($input, $id);

        return $this->sendResponse($farm->toArray(), 'Farm updated successfully');
    }

    /**
     * Remove the specified Farm from storage.
     * DELETE /farms/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Farm $farm */
        $farm = $this->farmRepository->find($id);

        if (empty($farm)) {
            return $this->sendError('Farm not found');
        }

        $farm->delete();

        return $this->sendSuccess('Farm deleted successfully');
    }
}
