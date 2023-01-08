<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFaqCategoryRequest;
use App\Http\Requests\UpdateFaqCategoryRequest;
use App\Repositories\FaqCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\FaqCategory;

class FaqCategoryController extends AppBaseController
{
    /** @var FaqCategoryRepository $faqCategoryRepository*/
    private $faqCategoryRepository;

    public function __construct(FaqCategoryRepository $faqCategoryRepo)
    {
        $this->faqCategoryRepository = $faqCategoryRepo;
    }

    /**
     * Display a listing of the FaqCategory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $faqCategories = Faq::latest()->paginate(5);

        return view('faq_categories.index')
            ->with('faqCategories', $faqCategories);
    }

    /**
     * Show the form for creating a new FaqCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('faq_categories.create');
    }

    /**
     * Store a newly created FaqCategory in storage.
     *
     * @param CreateFaqCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateFaqCategoryRequest $request)
    {
        $existing_name = FaqCategory::where('name',$request->name)->first();
       if(!$existing_name){

        $category = new FaqCategory();
        $category->name = $request->name;
        $category->save();

        $category = FaqCategory::find($category->id);
        $category->image = \App\Models\ImageUploader::upload($request->file('image'),'faqs');
        $category->save();


        Flash::success('Faq Category saved successfully.');

        return redirect(route('faqCategories.index'));
       }
    }

    /**
     * Display the specified FaqCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $faqCategory = $this->faqCategoryRepository->find($id);

        if (empty($faqCategory)) {
            Flash::error('Faq Category not found');

            return redirect(route('faqCategories.index'));
        }

        return view('faq_categories.show')->with('faqCategory', $faqCategory);
    }

    /**
     * Show the form for editing the specified FaqCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $faqCategory = $this->faqCategoryRepository->find($id);

        if (empty($faqCategory)) {
            Flash::error('Faq Category not found');

            return redirect(route('faqCategories.index'));
        }

        return view('faq_categories.edit')->with('faqCategory', $faqCategory);
    }

    /**
     * Update the specified FaqCategory in storage.
     *
     * @param int $id
     * @param UpdateFaqCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFaqCategoryRequest $request)
    {


        $faqCategory = FaqCategory::find($id);

        if (empty($$faqCategory)) {
            Flash::error('Faq Category not found');

            return redirect(route('faqCategories.index'));
        }

        if($faqCategory){

            $faqCategory->name = $request->name;
            $faqCategory->image = $request->image;


            if(!empty($request->file('image'))){
                $faqCategory->image = \App\Models\ImageUploader::upload($request->file('image'),'faqs');
            }
            $faqCategory->save();
            $faqCategory = $this->faqCategoryRepository->update($request->all(), $id);
            Flash::success('Faq Category updated successfully.');

            return redirect(route('faqCategories.index'));

        }




    }

    /**
     * Remove the specified FaqCategory from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $faqCategory = $this->faqCategoryRepository->find($id);

        if (empty($faqCategory)) {
            Flash::error('Faq Category not found');

            return redirect(route('faqCategories.index'));
        }

        $this->faqCategoryRepository->delete($id);

        Flash::success('Faq Category deleted successfully.');

        return redirect(route('faqCategories.index'));
    }
}
