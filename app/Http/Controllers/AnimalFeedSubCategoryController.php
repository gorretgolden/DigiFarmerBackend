<?php

namespace App\Http\Controllers;

use App\DataTables\AnimalFeedSubCategoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnimalFeedSubCategoryRequest;
use App\Http\Requests\UpdateAnimalFeedSubCategoryRequest;
use App\Repositories\AnimalFeedSubCategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AnimalFeedSubCategoryController extends AppBaseController
{
    /** @var AnimalFeedSubCategoryRepository $animalFeedSubCategoryRepository*/
    private $animalFeedSubCategoryRepository;

    public function __construct(AnimalFeedSubCategoryRepository $animalFeedSubCategoryRepo)
    {
        $this->animalFeedSubCategoryRepository = $animalFeedSubCategoryRepo;
    }

    /**
     * Display a listing of the AnimalFeedSubCategory.
     *
     * @param AnimalFeedSubCategoryDataTable $animalFeedSubCategoryDataTable
     *
     * @return Response
     */
    public function index(AnimalFeedSubCategoryDataTable $animalFeedSubCategoryDataTable)
    {
        return $animalFeedSubCategoryDataTable->render('animal_feed_sub_categories.index');
    }

    /**
     * Show the form for creating a new AnimalFeedSubCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('animal_feed_sub_categories.create');
    }

    /**
     * Store a newly created AnimalFeedSubCategory in storage.
     *
     * @param CreateAnimalFeedSubCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimalFeedSubCategoryRequest $request)
    {
        $input = $request->all();

        $animalFeedSubCategory = $this->animalFeedSubCategoryRepository->create($input);

        Flash::success('Animal Feed Sub Category saved successfully.');

        return redirect(route('animalFeedSubCategories.index'));
    }

    /**
     * Display the specified AnimalFeedSubCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $animalFeedSubCategory = $this->animalFeedSubCategoryRepository->find($id);

        if (empty($animalFeedSubCategory)) {
            Flash::error('Animal Feed Sub Category not found');

            return redirect(route('animalFeedSubCategories.index'));
        }

        return view('animal_feed_sub_categories.show')->with('animalFeedSubCategory', $animalFeedSubCategory);
    }

    /**
     * Show the form for editing the specified AnimalFeedSubCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $animalFeedSubCategory = $this->animalFeedSubCategoryRepository->find($id);

        if (empty($animalFeedSubCategory)) {
            Flash::error('Animal Feed Sub Category not found');

            return redirect(route('animalFeedSubCategories.index'));
        }

        return view('animal_feed_sub_categories.edit')->with('animalFeedSubCategory', $animalFeedSubCategory);
    }

    /**
     * Update the specified AnimalFeedSubCategory in storage.
     *
     * @param int $id
     * @param UpdateAnimalFeedSubCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimalFeedSubCategoryRequest $request)
    {
        $animalFeedSubCategory = $this->animalFeedSubCategoryRepository->find($id);

        if (empty($animalFeedSubCategory)) {
            Flash::error('Animal Feed Sub Category not found');

            return redirect(route('animalFeedSubCategories.index'));
        }

        $animalFeedSubCategory = $this->animalFeedSubCategoryRepository->update($request->all(), $id);

        Flash::success('Animal Feed Sub Category updated successfully.');

        return redirect(route('animalFeedSubCategories.index'));
    }

    /**
     * Remove the specified AnimalFeedSubCategory from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $animalFeedSubCategory = $this->animalFeedSubCategoryRepository->find($id);

        if (empty($animalFeedSubCategory)) {
            Flash::error('Animal Feed Sub Category not found');

            return redirect(route('animalFeedSubCategories.index'));
        }

        $this->animalFeedSubCategoryRepository->delete($id);

        Flash::success('Animal Feed Sub Category deleted successfully.');

        return redirect(route('animalFeedSubCategories.index'));
    }
}
