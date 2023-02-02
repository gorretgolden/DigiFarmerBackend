<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRentVendorCategoryAPIRequest;
use App\Http\Requests\API\UpdateRentVendorCategoryAPIRequest;
use App\Models\RentVendorCategory;
use App\Repositories\RentVendorCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class RentVendorCategoryController
 * @package App\Http\Controllers\API
 */

class RentVendorCategoryAPIController extends AppBaseController
{
    /** @var  RentVendorCategoryRepository */
    private $rentVendorCategoryRepository;

    public function __construct(RentVendorCategoryRepository $rentVendorCategoryRepo)
    {
        $this->rentVendorCategoryRepository = $rentVendorCategoryRepo;
    }

    /**
     * Display a listing of the RentVendorCategory.
     * GET|HEAD /rentVendorCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rentVendorCategories = RentVendorCategory::latest()->get(['id','name']);
        return $this->sendResponse($rentVendorCategories->toArray(), 'Rent Vendor Categories retrieved successfully');
    }

    /**
     * Store a newly created RentVendorCategory in storage.
     * POST /rentVendorCategories
     *
     * @param CreateRentVendorCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRentVendorCategoryAPIRequest $request)
    {
        $input = $request->all();

        $rentVendorCategory = $this->rentVendorCategoryRepository->create($input);

        return $this->sendResponse($rentVendorCategory->toArray(), 'Rent Vendor Category saved successfully');
    }

    /**
     * Display the specified RentVendorCategory.
     * GET|HEAD /rentVendorCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var RentVendorCategory $rentVendorCategory */
        $rentVendorCategory = $this->rentVendorCategoryRepository->find($id);

        if (empty($rentVendorCategory)) {
            return $this->sendError('Rent Vendor Category not found');
        }

        return $this->sendResponse($rentVendorCategory->toArray(), 'Rent Vendor Category retrieved successfully');
    }

    /**
     * Update the specified RentVendorCategory in storage.
     * PUT/PATCH /rentVendorCategories/{id}
     *
     * @param int $id
     * @param UpdateRentVendorCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRentVendorCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var RentVendorCategory $rentVendorCategory */
        $rentVendorCategory = $this->rentVendorCategoryRepository->find($id);

        if (empty($rentVendorCategory)) {
            return $this->sendError('Rent Vendor Category not found');
        }

        $rentVendorCategory = $this->rentVendorCategoryRepository->update($input, $id);

        return $this->sendResponse($rentVendorCategory->toArray(), 'RentVendorCategory updated successfully');
    }

    /**
     * Remove the specified RentVendorCategory from storage.
     * DELETE /rentVendorCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var RentVendorCategory $rentVendorCategory */
        $rentVendorCategory = $this->rentVendorCategoryRepository->find($id);

        if (empty($rentVendorCategory)) {
            return $this->sendError('Rent Vendor Category not found');
        }

        $rentVendorCategory->delete();

        return $this->sendSuccess('Rent Vendor Category deleted successfully');
    }
}
