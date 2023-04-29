<?php

namespace App\Http\Controllers;

use App\DataTables\CategoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use DB;
use App\Models\SubCategory;

class CategoryController extends AppBaseController
{
    /** @var CategoryRepository $categoryRepository*/
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Category.
     *
     * @param CategoryDataTable $categoryDataTable
     *
     * @return Response
     */
    public function index(CategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('categories.index');
    }


    //sub categories
    public function fetchCategorySubCategory(Request $request)
    {


      $data['sub_categories'] = SubCategory::where("category_id", $request->category_id)->get(["name","id"]);

        return response()->json($data);
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {



        $category = new category();
        $category->name = ucwords($request->name);
        $category->type = $request->type;
        $category->is_active = $request->is_active;
        $category->save();


        $category = Category::find($category->id);
        $category->image = \App\Models\ImageUploader::upload($request->file('image'),'categories');
        $category->save();


        Flash::success('Category '.$category->name. ' saved successfully under '.$request->type);


        return redirect(route('categories.index'));




    }

    /**
     * Display the specified Category.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        return view('categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        return view('categories.edit')->with('category', $category);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param int $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $category = Category::find($id);


        if (empty($category)) {
            Flash::error('Category not found');
            return redirect(route('categories.index'));
        }else{


            $category->name = ucwords($request->name);
            $category->is_active = $request->is_active;
            $category->type = $request->type;
            $category->save();


            if(!empty($request->file('image'))){
                File::delete('storage/categories/'.$category->image);
                $category->image = \App\Models\ImageUploader::upload($request->file('image'),'categories');
                $category->save();
            }else{


                $category->image = $request->image;
            }
        }


        Flash::success('Category updated successfully.');

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        $this->categoryRepository->delete($id);

        Flash::success('Category deleted successfully.');

        return redirect(route('categories.index'));
    }
}
