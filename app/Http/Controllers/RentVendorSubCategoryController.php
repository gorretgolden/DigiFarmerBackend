<?php

namespace App\Http\Controllers;

use App\DataTables\RentVendorSubCategoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRentVendorSubCategoryRequest;
use App\Http\Requests\UpdateRentVendorSubCategoryRequest;
use App\Repositories\RentVendorSubCategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class RentVendorSubCategoryController extends AppBaseController
{
    /** @var RentVendorSubCategoryRepository $rentVendorSubCategoryRepository*/
    private $rentVendorSubCategoryRepository;

    public function __construct(RentVendorSubCategoryRepository $rentVendorSubCategoryRepo)
    {
        $this->rentVendorSubCategoryRepository = $rentVendorSubCategoryRepo;
    }

    /**
     * Display a listing of the RentVendorSubCategory.
     *
     * @param RentVendorSubCategoryDataTable $rentVendorSubCategoryDataTable
     *
     * @return Response
     */
    public function index(RentVendorSubCategoryDataTable $rentVendorSubCategoryDataTable)
    {
        return $rentVendorSubCategoryDataTable->render('rent_vendor_sub_categories.index');
    }

    /**
     * Show the form for creating a new RentVendorSubCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('rent_vendor_sub_categories.create');
    }

    /**
     * Store a newly created RentVendorSubCategory in storage.
     *
     * @param CreateRentVendorSubCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateRentVendorSubCategoryRequest $request)
    {
        $input = $request->all();

        $rentVendorSubCategory = $this->rentVendorSubCategoryRepository->create($input);

        Flash::success('Rent Vendor Sub Category saved successfully.');

        return redirect(route('rentVendorSubCategories.index'));
    }

    /**
     * Display the specified RentVendorSubCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rentVendorSubCategory = $this->rentVendorSubCategoryRepository->find($id);

        if (empty($rentVendorSubCategory)) {
            Flash::error('Rent Vendor Sub Category not found');

            return redirect(route('rentVendorSubCategories.index'));
        }

        return view('rent_vendor_sub_categories.show')->with('rentVendorSubCategory', $rentVendorSubCategory);
    }

    /**
     * Show the form for editing the specified RentVendorSubCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $rentVendorSubCategory = $this->rentVendorSubCategoryRepository->find($id);

        if (empty($rentVendorSubCategory)) {
            Flash::error('Rent Vendor Sub Category not found');

            return redirect(route('rentVendorSubCategories.index'));
        }

        return view('rent_vendor_sub_categories.edit')->with('rentVendorSubCategory', $rentVendorSubCategory);
    }

    /**
     * Update the specified RentVendorSubCategory in storage.
     *
     * @param int $id
     * @param UpdateRentVendorSubCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRentVendorSubCategoryRequest $request)
    {
        $rentVendorSubCategory = $this->rentVendorSubCategoryRepository->find($id);

        if (empty($rentVendorSubCategory)) {
            Flash::error('Rent Vendor Sub Category not found');

            return redirect(route('rentVendorSubCategories.index'));
        }

        $rentVendorSubCategory = $this->rentVendorSubCategoryRepository->update($request->all(), $id);

        Flash::success('Rent Vendor Sub Category updated successfully.');

        return redirect(route('rentVendorSubCategories.index'));
    }

    /**
     * Remove the specified RentVendorSubCategory from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rentVendorSubCategory = $this->rentVendorSubCategoryRepository->find($id);

        if (empty($rentVendorSubCategory)) {
            Flash::error('Rent Vendor Sub Category not found');

            return redirect(route('rentVendorSubCategories.index'));
        }

        $this->rentVendorSubCategoryRepository->delete($id);

        Flash::success('Rent Vendor Sub Category deleted successfully.');

        return redirect(route('rentVendorSubCategories.index'));
    }
}
