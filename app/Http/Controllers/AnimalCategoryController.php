<?php

namespace App\Http\Controllers;

use App\DataTables\AnimalCategoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnimalCategoryRequest;
use App\Http\Requests\UpdateAnimalCategoryRequest;
use App\Repositories\AnimalCategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\AnimalCategory;
use Illuminate\Http\Request;

class AnimalCategoryController extends AppBaseController
{
    /** @var AnimalCategoryRepository $animalCategoryRepository*/
    private $animalCategoryRepository;

    public function __construct(AnimalCategoryRepository $animalCategoryRepo)
    {
        $this->animalCategoryRepository = $animalCategoryRepo;
    }

    /**
     * Display a listing of the AnimalCategory.
     *
     * @param AnimalCategoryDataTable $animalCategoryDataTable
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $animalCategories = AnimalCategory::latest()->paginate(6);

        return view('animal_categories.index')
            ->with('animalCategories', $animalCategories);
    }

    /**
     * Show the form for creating a new AnimalCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('animal_categories.create');
    }

    /**
     * Store a newly created AnimalCategory in storage.
     *
     * @param CreateAnimalCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimalCategoryRequest $request)
    {
        $input = $request->all();


        if(AnimalCategory::where('name',$request->name)->first()){
            Flash::error('Animal Category name already exists');

            return redirect(route('animalCategories.index'));

        }else{

            $animalCategory = new AnimalCategory();
            $animalCategory->name = $request->name;
            $animalCategory->image = $request->image;
            $animalCategory->save();

            $file = $request->file('image');
            $animalCategory  = AnimalCategory::find($animalCategory->id);
            $animalCategory->image = \App\Models\ImageUploader::upload($request->file('image'),'animal_categories');
            $animalCategory->save();



            $animalCategory->save();


            Flash::success('Animal Category saved successfully.');

             return redirect(route('animalCategories.index'));

        }


    }

    /**
     * Display the specified AnimalCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $animalCategory = $this->animalCategoryRepository->find($id);

        if (empty($animalCategory)) {
            Flash::error('Animal Category not found');

            return redirect(route('animalCategories.index'));
        }

        return view('animal_categories.show')->with('animalCategory', $animalCategory);
    }

    /**
     * Show the form for editing the specified AnimalCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $animalCategory = $this->animalCategoryRepository->find($id);

        if (empty($animalCategory)) {
            Flash::error('Animal Category not found');

            return redirect(route('animalCategories.index'));
        }

        return view('animal_categories.edit')->with('animalCategory', $animalCategory);
    }

    /**
     * Update the specified AnimalCategory in storage.
     *
     * @param int $id
     * @param UpdateAnimalCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimalCategoryRequest $request)
    {
        $animalCategory = $this->animalCategoryRepository->find($id);
        $animalCategory->fill($request->all());


        if (empty($animalCategory)) {
            Flash::error('Animal Category not found');

            return redirect(route('animalCategories.index'));
        }else{

            $animalCategory->name = $request->name;
            if(!empty($request->file('image'))){
                $animalCategory->image = \App\Models\ImageUploader::upload($request->file('image'),'animal_categories');
            }
            $animalCategory->save();

            Flash::success('Animal Category updated successfully.');

            return redirect(route('animalCategories.index'));
        }




    }

    /**
     * Remove the specified AnimalCategory from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $animalCategory = $this->animalCategoryRepository->find($id);

        if (empty($animalCategory)) {
            Flash::error('Animal Category not found');

            return redirect(route('animalCategories.index'));
        }

        $this->animalCategoryRepository->delete($id);

        Flash::success('Animal Category deleted successfully.');

        return redirect(route('animalCategories.index'));
    }
}

