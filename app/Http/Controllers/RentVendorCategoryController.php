<?php

namespace App\Http\Controllers;

use App\DataTables\RentVendorCategoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRentVendorCategoryRequest;
use App\Http\Requests\UpdateRentVendorCategoryRequest;
use App\Repositories\RentVendorCategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class RentVendorCategoryController extends AppBaseController
{
    /** @var RentVendorCategoryRepository $rentVendorCategoryRepository*/
    private $rentVendorCategoryRepository;

    public function __construct(RentVendorCategoryRepository $rentVendorCategoryRepo)
    {
        $this->rentVendorCategoryRepository = $rentVendorCategoryRepo;
    }

    /**
     * Display a listing of the RentVendorCategory.
     *
     * @param RentVendorCategoryDataTable $rentVendorCategoryDataTable
     *
     * @return Response
     */
    public function index(RentVendorCategoryDataTable $rentVendorCategoryDataTable)
    {
        return $rentVendorCategoryDataTable->render('rent_vendor_categories.index');
    }

    /**
     * Show the form for creating a new RentVendorCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('rent_vendor_categories.create');
    }

    /**
     * Store a newly created RentVendorCategory in storage.
     *
     * @param CreateRentVendorCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateRentVendorCategoryRequest $request)
    {
        $input = $request->all();

        $rentVendorCategory = $this->rentVendorCategoryRepository->create($input);

        Flash::success('Rent Vendor Category saved successfully.');

        return redirect(route('rentVendorCategories.index'));
    }

    /**
     * Display the specified RentVendorCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rentVendorCategory = $this->rentVendorCategoryRepository->find($id);

        if (empty($rentVendorCategory)) {
            Flash::error('Rent Vendor Category not found');

            return redirect(route('rentVendorCategories.index'));
        }

        return view('rent_vendor_categories.show')->with('rentVendorCategory', $rentVendorCategory);
    }

    /**
     * Show the form for editing the specified RentVendorCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $rentVendorCategory = $this->rentVendorCategoryRepository->find($id);

        if (empty($rentVendorCategory)) {
            Flash::error('Rent Vendor Category not found');

            return redirect(route('rentVendorCategories.index'));
        }

        return view('rent_vendor_categories.edit')->with('rentVendorCategory', $rentVendorCategory);
    }

    /**
     * Update the specified RentVendorCategory in storage.
     *
     * @param int $id
     * @param UpdateRentVendorCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRentVendorCategoryRequest $request)
    {
        $rentVendorCategory = $this->rentVendorCategoryRepository->find($id);

        if (empty($rentVendorCategory)) {
            Flash::error('Rent Vendor Category not found');

            return redirect(route('rentVendorCategories.index'));
        }

        $rentVendorCategory = $this->rentVendorCategoryRepository->update($request->all(), $id);

        Flash::success('Rent Vendor Category updated successfully.');

        return redirect(route('rentVendorCategories.index'));
    }

    /**
     * Remove the specified RentVendorCategory from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rentVendorCategory = $this->rentVendorCategoryRepository->find($id);

        if (empty($rentVendorCategory)) {
            Flash::error('Rent Vendor Category not found');

            return redirect(route('rentVendorCategories.index'));
        }

        $this->rentVendorCategoryRepository->delete($id);

        Flash::success('Rent Vendor Category deleted successfully.');

        return redirect(route('rentVendorCategories.index'));
    }
}
