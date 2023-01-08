<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStatusAPIRequest;
use App\Http\Requests\API\UpdateStatusAPIRequest;
use App\Models\Status;
use App\Repositories\StatusRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class StatusController
 * @package App\Http\Controllers\API
 */

class StatusAPIController extends AppBaseController
{
    /** @var  StatusRepository */
    private $statusRepository;

    public function __construct(StatusRepository $statusRepo)
    {
        $this->statusRepository = $statusRepo;
    }

    /**
     * Display a listing of the Status.
     * GET|HEAD /statuses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $statuses = Status::all('id','name');
        $response = [
            'success'=>true,
            'data'=> $statuses,
            'message'=> 'statuses retrieved successfully'
         ];
         return response()->json($response,200);


    }

    /**
     * Store a newly created Status in storage.
     * POST /statuses
     *
     * @param CreateStatusAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateStatusAPIRequest $request)
    {
        $input = $request->all();

        $status = $this->statusRepository->create($input);

        return $this->sendResponse($status->toArray(), 'Status saved successfully');
    }

    /**
     * Display the specified Status.
     * GET|HEAD /statuses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Status $status */
        $status = $this->statusRepository->find($id);

        if (empty($status)) {
            return $this->sendError('Status not found');
        }

        return $this->sendResponse($status->toArray(), 'Status retrieved successfully');
    }

    /**
     * Update the specified Status in storage.
     * PUT/PATCH /statuses/{id}
     *
     * @param int $id
     * @param UpdateStatusAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStatusAPIRequest $request)
    {
        $input = $request->all();

        /** @var Status $status */
        $status = $this->statusRepository->find($id);

        if (empty($status)) {
            return $this->sendError('Status not found');
        }

        $status = $this->statusRepository->update($input, $id);

        return $this->sendResponse($status->toArray(), 'Status updated successfully');
    }

    /**
     * Remove the specified Status from storage.
     * DELETE /statuses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Status $status */
        $status = $this->statusRepository->find($id);

        if (empty($status)) {
            return $this->sendError('Status not found');
        }

        $status->delete();

        return $this->sendSuccess('Status deleted successfully');
    }
}
