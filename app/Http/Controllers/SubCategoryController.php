<?php

namespace App\Http\Controllers;

use App\DataTables\SubCategoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Repositories\SubCategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SubCategoryController extends AppBaseController
{
    /** @var SubCategoryRepository $subCategoryRepository*/
    private $subCategoryRepository;

    public function __construct(SubCategoryRepository $subCategoryRepo)
    {
        $this->subCategoryRepository = $subCategoryRepo;
    }

    /**
     * Display a listing of the SubCategory.
     *
     * @param SubCategoryDataTable $subCategoryDataTable
     *
     * @return Response
     */
    public function index(SubCategoryDataTable $subCategoryDataTable)
    {
        return $subCategoryDataTable->render('sub_categories.index');
    }



    /**
     * Show the form for creating a new SubCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('sub_categories.create');
    }

    /**
     * Store a newly created SubCategory in storage.
     *
     * @param CreateSubCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateSubCategoryRequest $request)
    {

       // dd($request->all());
        $category = Category::find($request->category_id);

        if(SubCategory::where('name',ucwords($request->name))->where('category_id',$request->category_id)->first()){
            Flash::error($request->name." already exits as a subcategory under ".$category->name);

            return redirect(route('subCategories.index'));
        }

        //existing animal feed category
        // if($category->name == 'Animal Feeds' && SubCategory::where('category_id',$category->id)->first()){

        //     Flash::error('Sub Category for animal feeds exits.');

        //     return redirect(route('subCategories.index'));
        // }


        $subCategory = new SubCategory();
        $subCategory->name = ucwords($request->name);
        $subCategory->category_id = $request->category_id;
        $subCategory->is_active = $request->is_active;
        $subCategory->save();

        if(!empty($request->image)){
            $subCategory = SubCategory::find($subCategory->id);
            $subCategory->image = \App\Models\ImageUploader::upload($request->file('image'),'sub_categories');
            $subCategory->save();

        }


        Flash::success('Sub Category saved successfully.');

        return redirect(route('subCategories.index'));
    }

    /**
     * Display the specified SubCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $subCategory = $this->subCategoryRepository->find($id);

        if (empty($subCategory)) {
            Flash::error('Sub Category not found');

            return redirect(route('subCategories.index'));
        }

        return view('sub_categories.show')->with('subCategory', $subCategory);
    }

    /**
     * Show the form for editing the specified SubCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subCategory = $this->subCategoryRepository->find($id);

        if (empty($subCategory)) {
            Flash::error('Sub Category not found');

            return redirect(route('subCategories.index'));
        }

        return view('sub_categories.edit')->with('subCategory', $subCategory);
    }

    /**
     * Update the specified SubCategory in storage.
     *
     * @param int $id
     * @param UpdateSubCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubCategoryRequest $request)
    {
        $subCategory = $this->subCategoryRepository->find($id);

        if (empty($subCategory)) {
            Flash::error('Sub Category not found');

            return redirect(route('subCategories.index'));
        }


        $subCategory->name = ucwords($request->name);
        $subCategory->is_active = $request->is_active;
        $subCategory->save();
        if(!empty($request->file('image'))){
            File::delete('storage/sub_categories/'.$subCategory->image);
            $subCategory->image = \App\Models\ImageUploader::upload($request->file('image'),'sub_categories');
            $subCategory->save();
        }else{


            $subCategory->image = $request->image;
        }



        Flash::success('Sub Category updated successfully.');

        return redirect(route('subCategories.index'));
    }

    /**
     * Remove the specified SubCategory from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $subCategory = $this->subCategoryRepository->find($id);

        if (empty($subCategory)) {
            Flash::error('Sub Category not found');

            return redirect(route('subCategories.index'));
        }

        $this->subCategoryRepository->delete($id);

        Flash::success('Sub Category deleted successfully.');

        return redirect(route('subCategories.index'));
    }
}
