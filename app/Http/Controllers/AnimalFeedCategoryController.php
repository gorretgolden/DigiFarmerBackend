<?php

namespace App\Http\Controllers;

use App\DataTables\AnimalFeedCategoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnimalFeedCategoryRequest;
use App\Http\Requests\UpdateAnimalFeedCategoryRequest;
use App\Repositories\AnimalFeedCategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;
use App\Models\AnimalFeedCategory;

class AnimalFeedCategoryController extends AppBaseController
{
    /** @var AnimalFeedCategoryRepository $animalFeedCategoryRepository*/
    private $animalFeedCategoryRepository;

    public function __construct(AnimalFeedCategoryRepository $animalFeedCategoryRepo)
    {
        $this->animalFeedCategoryRepository = $animalFeedCategoryRepo;
    }

    /**
     * Display a listing of the AnimalFeedCategory.
     *
     * @param AnimalFeedCategoryDataTable $animalFeedCategoryDataTable
     *
     * @return Response
     */
    public function index(AnimalFeedCategoryDataTable $animalFeedCategoryDataTable)
    {
        return $animalFeedCategoryDataTable->render('animal_feed_categories.index');
    }


    //get animal feeds for an animal category

    public function fetch_animal_category_feeds(Request $request)
    {


      $data['animal_feed_categories'] = AnimalFeedCategory::where("animal_category_id", $request->animal_category_id)->get(['name','id']);

        return response()->json($data);
    }

    public function animal_category_feeds(Request $request,$id)
    {


      $data['animal_feed_categories'] = AnimalFeedCategory::where("animal_category_id", $id)->get(['name','id']);

        return response()->json($data);
    }
    /**
     * Show the form for creating a new AnimalFeedCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('animal_feed_categories.create');
    }

    /**
     * Store a newly created AnimalFeedCategory in storage.
     *
     * @param CreateAnimalFeedCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimalFeedCategoryRequest $request)
    {
        $input = $request->all();
        //dd($input);

        $animalFeedCategory = $this->animalFeedCategoryRepository->create($input);

        Flash::success('Animal Feed Category saved successfully.');

        return redirect(route('animalFeedCategories.index'));
    }

    /**
     * Display the specified AnimalFeedCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $animalFeedCategory = $this->animalFeedCategoryRepository->find($id);

        if (empty($animalFeedCategory)) {
            Flash::error('Animal Feed Category not found');

            return redirect(route('animalFeedCategories.index'));
        }

        return view('animal_feed_categories.show')->with('animalFeedCategory', $animalFeedCategory);
    }

    /**
     * Show the form for editing the specified AnimalFeedCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $animalFeedCategory = $this->animalFeedCategoryRepository->find($id);

        if (empty($animalFeedCategory)) {
            Flash::error('Animal Feed Category not found');

            return redirect(route('animalFeedCategories.index'));
        }

        return view('animal_feed_categories.edit')->with('animalFeedCategory', $animalFeedCategory);
    }

    /**
     * Update the specified AnimalFeedCategory in storage.
     *
     * @param int $id
     * @param UpdateAnimalFeedCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimalFeedCategoryRequest $request)
    {
        $animalFeedCategory = $this->animalFeedCategoryRepository->find($id);

        if (empty($animalFeedCategory)) {
            Flash::error('Animal Feed Category not found');

            return redirect(route('animalFeedCategories.index'));
        }

        $animalFeedCategory = $this->animalFeedCategoryRepository->update($request->all(), $id);

        Flash::success('Animal Feed Category updated successfully.');

        return redirect(route('animalFeedCategories.index'));
    }

    /**
     * Remove the specified AnimalFeedCategory from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $animalFeedCategory = $this->animalFeedCategoryRepository->find($id);

        if (empty($animalFeedCategory)) {
            Flash::error('Animal Feed Category not found');

            return redirect(route('animalFeedCategories.index'));
        }

        $this->animalFeedCategoryRepository->delete($id);

        Flash::success('Animal Feed Category deleted successfully.');

        return redirect(route('animalFeedCategories.index'));
    }
}
