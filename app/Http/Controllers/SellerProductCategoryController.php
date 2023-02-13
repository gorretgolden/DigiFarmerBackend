<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSellerProductCategoryRequest;
use App\Http\Requests\UpdateSellerProductCategoryRequest;
use App\Repositories\SellerProductCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\SellerProductCategory;
use Illuminate\Support\Facades\File;

class SellerProductCategoryController extends AppBaseController
{
    /** @var SellerProductCategoryRepository $sellerProductCategoryRepository*/
    private $sellerProductCategoryRepository;

    public function __construct(SellerProductCategoryRepository $sellerProductCategoryRepo)
    {
        $this->sellerProductCategoryRepository = $sellerProductCategoryRepo;
    }

    /**
     * Display a listing of the SellerProductCategory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $sellerProductCategories = SellerProductCategory::latest()->paginate(10);

        return view('seller_product_categories.index')
            ->with('sellerProductCategories', $sellerProductCategories);
    }

    /**
     * Show the form for creating a new SellerProductCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('seller_product_categories.create');
    }

    /**
     * Store a newly created SellerProductCategory in storage.
     *
     * @param CreateSellerProductCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateSellerProductCategoryRequest $request)
    {
        $input = $request->all();

        $sellerProductCategory = new SellerProductCategory() ;
        $sellerProductCategory->name = $request->name;
        $sellerProductCategory->image = $request->image;
        $sellerProductCategory->save();

        $sellerProductCategory = SellerProductCategory::find($sellerProductCategory->id);

        $sellerProductCategory->image = \App\Models\ImageUploader::upload($request->file('image'),'seller_product_categories');
        $sellerProductCategory->save();

        Flash::success('Seller Product Category saved successfully.');

        return redirect(route('sellerProductCategories.index'));
    }

    /**
     * Display the specified SellerProductCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sellerProductCategory = $this->sellerProductCategoryRepository->find($id);

        if (empty($sellerProductCategory)) {
            Flash::error('Seller Product Category not found');

            return redirect(route('sellerProductCategories.index'));
        }

        return view('seller_product_categories.show')->with('sellerProductCategory', $sellerProductCategory);
    }

    /**
     * Show the form for editing the specified SellerProductCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sellerProductCategory = $this->sellerProductCategoryRepository->find($id);

        if (empty($sellerProductCategory)) {
            Flash::error('Seller Product Category not found');

            return redirect(route('sellerProductCategories.index'));
        }

        return view('seller_product_categories.edit')->with('sellerProductCategory', $sellerProductCategory);
    }

    /**
     * Update the specified SellerProductCategory in storage.
     *
     * @param int $id
     * @param UpdateSellerProductCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:100'
        ]);
        $sellerProductCategory = $this->sellerProductCategoryRepository->find($id);

        if (empty($sellerProductCategory)) {
            Flash::error('Seller Product Category not found');

            return redirect(route('sellerProductCategories.index'));
        }

        $sellerProductCategory->name = $request->name;
        if(!empty($request->file('image'))){
            File::delete('storage/seller_product_categories/'.$sellerProductCategory->image);
            $sellerProductCategory->image = \App\Models\ImageUploader::upload($request->file('image'),'seller_product_categories');
            $sellerProductCategory->save();
        }

        $sellerProductCategory->save();


        Flash::success('Seller Product Category updated successfully.');

        return redirect(route('sellerProductCategories.index'));
    }

    /**
     * Remove the specified SellerProductCategory from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sellerProductCategory = $this->sellerProductCategoryRepository->find($id);

        if (empty($sellerProductCategory)) {
            Flash::error('Seller Product Category not found');

            return redirect(route('sellerProductCategories.index'));
        }

        $this->sellerProductCategoryRepository->delete($id);

        Flash::success('Seller Product Category deleted successfully.');

        return redirect(route('sellerProductCategories.index'));
    }
}
