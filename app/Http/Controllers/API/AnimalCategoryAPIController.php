<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnimalCategoryAPIRequest;
use App\Http\Requests\API\UpdateAnimalCategoryAPIRequest;
use App\Models\AnimalCategory;
use App\Repositories\AnimalCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AnimalCategoryController
 * @package App\Http\Controllers\API
 */

class AnimalCategoryAPIController extends AppBaseController
{
    /** @var  AnimalCategoryRepository */
    private $animalCategoryRepository;

    public function __construct(AnimalCategoryRepository $animalCategoryRepo)
    {
        $this->animalCategoryRepository = $animalCategoryRepo;
    }

    /**
     * Display a listing of the AnimalCategory.
     * GET|HEAD /animalCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $animalCategories = AnimalCategory::where('is_active',1)->latest()->get(['id','name','image']);
        $response = [
            'success'=>true,
            'data'=> $animalCategories,
            'message'=> 'Animal Categories retrieved successfully'
         ];
         return response()->json($response,200);
    }

    /**
     * Store a newly created AnimalCategory in storage.
     * POST /animalCategories
     *
     * @param CreateAnimalCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimalCategoryAPIRequest $request)
    {
        $input = $request->all();
        $input['image'] = $request->image;

        $animalCategory = $this->animalCategoryRepository->create($input);

        return $this->sendResponse($animalCategory->toArray(), 'Animal Category saved successfully');
    }

    /**
     * Display the specified AnimalCategory.
     * GET|HEAD /animalCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AnimalCategory $animalCategory */
        $animalCategory = $this->animalCategoryRepository->find($id);

        if (empty($animalCategory)) {
            return $this->sendError('Animal Category not found');
        }

        return $this->sendResponse($animalCategory->toArray(), 'Animal Category retrieved successfully');
    }

    /**
     * Update the specified AnimalCategory in storage.
     * PUT/PATCH /animalCategories/{id}
     *
     * @param int $id
     * @param UpdateAnimalCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimalCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var AnimalCategory $animalCategory */
        $animalCategory = $this->animalCategoryRepository->find($id);

        if (empty($animalCategory)) {
            return $this->sendError('Animal Category not found');
        }

        $animalCategory = $this->animalCategoryRepository->update($input, $id);

        return $this->sendResponse($animalCategory->toArray(), 'AnimalCategory updated successfully');
    }

    /**
     * Remove the specified AnimalCategory from storage.
     * DELETE /animalCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AnimalCategory $animalCategory */
        $animalCategory = $this->animalCategoryRepository->find($id);

        if (empty($animalCategory)) {
            return $this->sendError('Animal Category not found');
        }

        $animalCategory->delete();

        return $this->sendSuccess('Animal Category deleted successfully');
    }
}
