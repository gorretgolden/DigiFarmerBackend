<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFinanceVendorCategoriesAPIRequest;
use App\Http\Requests\API\UpdateFinanceVendorCategoriesAPIRequest;
use App\Models\FinanceVendorCategories;
use App\Repositories\FinanceVendorCategoriesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FinanceVendorCategoriesController
 * @package App\Http\Controllers\API
 */

class FinanceVendorCategoriesAPIController extends AppBaseController
{
    /** @var  FinanceVendorCategoriesRepository */
    private $financeVendorCategoriesRepository;

    public function __construct(FinanceVendorCategoriesRepository $financeVendorCategoriesRepo)
    {
        $this->financeVendorCategoriesRepository = $financeVendorCategoriesRepo;
    }

    /**
     * Display a listing of the FinanceVendorCategories.
     * GET|HEAD /financeVendorCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $financeVendorCategories = FinanceVendorCategories::orderBy('name','ASC')->get(['id','name']);
        return $this->sendResponse($financeVendorCategories->toArray(), 'Finance Vendor Categories retrieved successfully');
    }

    /**
     * Store a newly created FinanceVendorCategories in storage.
     * POST /financeVendorCategories
     *
     * @param CreateFinanceVendorCategoriesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFinanceVendorCategoriesAPIRequest $request)
    {
        $input = $request->all();

        $financeVendorCategories = $this->financeVendorCategoriesRepository->create($input);

        return $this->sendResponse($financeVendorCategories->toArray(), 'Finance Vendor Categories saved successfully');
    }

    /**
     * Display the specified FinanceVendorCategories.
     * GET|HEAD /financeVendorCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FinanceVendorCategories $financeVendorCategories */
        $financeVendorCategories = $this->financeVendorCategoriesRepository->find($id);

        if (empty($financeVendorCategories)) {
            return $this->sendError('Finance Vendor Categories not found');
        }

        return $this->sendResponse($financeVendorCategories->toArray(), 'Finance Vendor Categories retrieved successfully');
    }

    /**
     * Update the specified FinanceVendorCategories in storage.
     * PUT/PATCH /financeVendorCategories/{id}
     *
     * @param int $id
     * @param UpdateFinanceVendorCategoriesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFinanceVendorCategoriesAPIRequest $request)
    {
        $input = $request->all();

        /** @var FinanceVendorCategories $financeVendorCategories */
        $financeVendorCategories = $this->financeVendorCategoriesRepository->find($id);

        if (empty($financeVendorCategories)) {
            return $this->sendError('Finance Vendor Categories not found');
        }

        $financeVendorCategories = $this->financeVendorCategoriesRepository->update($input, $id);

        return $this->sendResponse($financeVendorCategories->toArray(), 'FinanceVendorCategories updated successfully');
    }

    /**
     * Remove the specified FinanceVendorCategories from storage.
     * DELETE /financeVendorCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FinanceVendorCategories $financeVendorCategories */
        $financeVendorCategories = $this->financeVendorCategoriesRepository->find($id);

        if (empty($financeVendorCategories)) {
            return $this->sendError('Finance Vendor Categories not found');
        }

        $financeVendorCategories->delete();

        return $this->sendSuccess('Finance Vendor Categories deleted successfully');
    }
}
