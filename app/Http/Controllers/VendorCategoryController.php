<?php

namespace App\Http\Controllers;

use App\DataTables\VendorCategoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateVendorCategoryRequest;
use App\Http\Requests\UpdateVendorCategoryRequest;
use App\Repositories\VendorCategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;
use App\Models\VendorCategory;

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
     * @param VendorCategoryDataTable $vendorCategoryDataTable
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $vendorCategories = VendorCategory::latest()->paginate(6);

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
           //existing name
           $existing_name = VendorCategory::where('name',$request->name)->first();

           if(!$existing_name){

              $new_vendor_category = new VendorCategory();
              $new_vendor_category->name = $request->name;
              $new_vendor_category->image = $request->image;
              $new_vendor_category->save();

              $new_vendor_category = VendorCategory::find($new_vendor_category->id);

              $new_vendor_category->image = \App\Models\ImageUploader::upload($request->file('image'),'vendor_categories');
              $new_vendor_category->save();

              Flash::success('Vendor Category saved successfully.');
              return redirect(route('vendorCategories.index'));
           }
           else{
              Flash::error('Crop already exists');
              return redirect(route('vendorCategories.index'));
           }

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
