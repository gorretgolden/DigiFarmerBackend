<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnimalFeedSubCategoryAPIRequest;
use App\Http\Requests\API\UpdateAnimalFeedSubCategoryAPIRequest;
use App\Models\AnimalFeedSubCategory;
use App\Repositories\AnimalFeedSubCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AnimalFeedSubCategoryController
 * @package App\Http\Controllers\API
 */

class AnimalFeedSubCategoryAPIController extends AppBaseController
{
    /** @var  AnimalFeedSubCategoryRepository */
    private $animalFeedSubCategoryRepository;

    public function __construct(AnimalFeedSubCategoryRepository $animalFeedSubCategoryRepo)
    {
        $this->animalFeedSubCategoryRepository = $animalFeedSubCategoryRepo;
    }

    /**
     * Display a listing of the AnimalFeedSubCategory.
     * GET|HEAD /animalFeedSubCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $animalFeedSubCategories = AnimalFeedSubCategory::with('category','animal_feeds')->get();
        $response = [
            'success'=>true,
            'data'=> $animalFeedSubCategories,
            'message'=> 'Animal Feed Sub Categories retrieved successfully'
         ];
         return response()->json($response,200);


    }

    /**
     * Store a newly created AnimalFeedSubCategory in storage.
     * POST /animalFeedSubCategories
     *
     * @param CreateAnimalFeedSubCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimalFeedSubCategoryAPIRequest $request)
    {
        $input = $request->all();

        $animalFeedSubCategory = $this->animalFeedSubCategoryRepository->create($input);

        return $this->sendResponse($animalFeedSubCategory->toArray(), 'Animal Feed Sub Category saved successfully');
    }

    /**
     * Display the specified AnimalFeedSubCategory.
     * GET|HEAD /animalFeedSubCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AnimalFeedSubCategory $animalFeedSubCategory */
        $animalFeedSubCategory = $this->animalFeedSubCategoryRepository->find($id);

        if (empty($animalFeedSubCategory)) {
            return $this->sendError('Animal Feed Sub Category not found');
        }
        else{
            $success['name'] = $animalFeedSubCategory->name;
            $success['category'] = $animalFeedSubCategory->category;
            $success['animal-feeds'] = $animalFeedSubCategory->animal_feeds;


            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Animal Feed Sub Category retrieved successfully'
             ];

             return response()->json($response,200);
        }


    }

    /**
     * Update the specified AnimalFeedSubCategory in storage.
     * PUT/PATCH /animalFeedSubCategories/{id}
     *
     * @param int $id
     * @param UpdateAnimalFeedSubCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimalFeedSubCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var AnimalFeedSubCategory $animalFeedSubCategory */
        $animalFeedSubCategory = $this->animalFeedSubCategoryRepository->find($id);

        if (empty($animalFeedSubCategory)) {
            return $this->sendError('Animal Feed Sub Category not found');
        }

        $animalFeedSubCategory = $this->animalFeedSubCategoryRepository->update($input, $id);

        return $this->sendResponse($animalFeedSubCategory->toArray(), 'AnimalFeedSubCategory updated successfully');
    }

    /**
     * Remove the specified AnimalFeedSubCategory from storage.
     * DELETE /animalFeedSubCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AnimalFeedSubCategory $animalFeedSubCategory */
        $animalFeedSubCategory = $this->animalFeedSubCategoryRepository->find($id);

        if (empty($animalFeedSubCategory)) {
            return $this->sendError('Animal Feed Sub Category not found');
        }

        $animalFeedSubCategory->delete();

        return $this->sendSuccess('Animal Feed Sub Category deleted successfully');
    }
}
