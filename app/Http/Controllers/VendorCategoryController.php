<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVendorCategoryRequest;
use App\Http\Requests\UpdateVendorCategoryRequest;
use App\Repositories\VendorCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class VendorCategoryController extends AppBaseController
{
    /** @var VendorCategoryRepository $vendorCategoryRepository*/
    private $vendorCategoryRepository;

    public function __construct(VendorCategoryRepository $vendorCategoryRepo)
    {
        $this->vendorCategoryRepository = $vendorCategoryRepo;
    }

    /**
     * Display a listing of the VendorCategory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $vendorCategories = $this->vendorCategoryRepository->all();

        return view('vendor_categories.index')
            ->with('vendorCategories', $vendorCategories);
    }

    /**
     * Show the form for creating a new VendorCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('vendor_categories.create');
    }

    /**
     * Store a newly created VendorCategory in storage.
     *
     * @param CreateVendorCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateVendorCategoryRequest $request)
    {
        $input = $request->all();

        $vendorCategory = $this->vendorCategoryRepository->create($input);

        Flash::success('Vendor Category saved successfully.');

        return redirect(route('vendorCategories.index'));
    }

    /**
     * Display the specified VendorCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $vendorCategory = $this->vendorCategoryRepository->find($id);

        if (empty($vendorCategory)) {
            Flash::error('Vendor Category not found');

            return redirect(route('vendorCategories.index'));
        }

        return view('vendor_categories.show')->with('vendorCategory', $vendorCategory);
    }

    /**
     * Show the form for editing the specified VendorCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $vendorCategory = $this->vendorCategoryRepository->find($id);

        if (empty($vendorCategory)) {
            Flash::error('Vendor Category not found');

            return redirect(route('vendorCategories.index'));
        }

        return view('vendor_categories.edit')->with('vendorCategory', $vendorCategory);
    }

    /**
     * Update the specified VendorCategory in storage.
     *
     * @param int $id
     * @param UpdateVendorCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVendorCategoryRequest $request)
    {
        $vendorCategory = $this->vendorCategoryRepository->find($id);

        if (empty($vendorCategory)) {
            Flash::error('Vendor Category not found');

            return redirect(route('vendorCategories.index'));
        }

        $vendorCategory = $this->vendorCategoryRepository->update($request->all(), $id);

        Flash::success('Vendor Category updated successfully.');

        return redirect(route('vendorCategories.index'));
    }

    /**
     * Remove the specified VendorCategory from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $vendorCategory = $this->vendorCategoryRepository->find($id);

        if (empty($vendorCategory)) {
            Flash::error('Vendor Category not found');

            return redirect(route('vendorCategories.index'));
        }

        $this->vendorCategoryRepository->delete($id);

        Flash::success('Vendor Category deleted successfully.');

        return redirect(route('vendorCategories.index'));
    }
}
