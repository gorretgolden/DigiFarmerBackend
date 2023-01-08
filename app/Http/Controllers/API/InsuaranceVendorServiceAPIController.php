<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInsuaranceVendorServiceAPIRequest;
use App\Http\Requests\API\UpdateInsuaranceVendorServiceAPIRequest;
use App\Models\InsuaranceVendorService;
use App\Repositories\InsuaranceVendorServiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class InsuaranceVendorServiceController
 * @package App\Http\Controllers\API
 */

class InsuaranceVendorServiceAPIController extends AppBaseController
{
    /** @var  InsuaranceVendorServiceRepository */
    private $insuaranceVendorServiceRepository;

    public function __construct(InsuaranceVendorServiceRepository $insuaranceVendorServiceRepo)
    {
        $this->insuaranceVendorServiceRepository = $insuaranceVendorServiceRepo;
    }

    /**
     * Display a listing of the InsuaranceVendorService.
     * GET|HEAD /insuaranceVendorServices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $insuaranceVendorServices = $this->insuaranceVendorServiceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($insuaranceVendorServices->toArray(), 'Insuarance Vendor Services retrieved successfully');
    }

    /**
     * Store a newly created InsuaranceVendorService in storage.
     * POST /insuaranceVendorServices
     *
     * @param CreateInsuaranceVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateInsuaranceVendorServiceAPIRequest $request)
    {
        $input = $request->all();

        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->create($input);

        return $this->sendResponse($insuaranceVendorService->toArray(), 'Insuarance Vendor Service saved successfully');
    }

    /**
     * Display the specified InsuaranceVendorService.
     * GET|HEAD /insuaranceVendorServices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var InsuaranceVendorService $insuaranceVendorService */
        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->find($id);

        if (empty($insuaranceVendorService)) {
            return $this->sendError('Insuarance Vendor Service not found');
        }

        return $this->sendResponse($insuaranceVendorService->toArray(), 'Insuarance Vendor Service retrieved successfully');
    }

    /**
     * Update the specified InsuaranceVendorService in storage.
     * PUT/PATCH /insuaranceVendorServices/{id}
     *
     * @param int $id
     * @param UpdateInsuaranceVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInsuaranceVendorServiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var InsuaranceVendorService $insuaranceVendorService */
        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->find($id);

        if (empty($insuaranceVendorService)) {
            return $this->sendError('Insuarance Vendor Service not found');
        }

        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->update($input, $id);

        return $this->sendResponse($insuaranceVendorService->toArray(), 'InsuaranceVendorService updated successfully');
    }

    /**
     * Remove the specified InsuaranceVendorService from storage.
     * DELETE /insuaranceVendorServices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var InsuaranceVendorService $insuaranceVendorService */
        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->find($id);

        if (empty($insuaranceVendorService)) {
            return $this->sendError('Insuarance Vendor Service not found');
        }

        $insuaranceVendorService->delete();

        return $this->sendSuccess('Insuarance Vendor Service deleted successfully');
    }
}
