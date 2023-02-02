<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnimalFeedCategoryAPIRequest;
use App\Http\Requests\API\UpdateAnimalFeedCategoryAPIRequest;
use App\Models\AnimalFeedCategory;
use App\Repositories\AnimalFeedCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;



/**
 * Class AnimalFeedCategoryController
 * @package App\Http\Controllers\API
 */

class AnimalFeedCategoryAPIController extends AppBaseController
{
    /** @var  AnimalFeedCategoryRepository */
    private $animalFeedCategoryRepository;

    public function __construct(AnimalFeedCategoryRepository $animalFeedCategoryRepo)
    {
        $this->animalFeedCategoryRepository = $animalFeedCategoryRepo;
    }

    /**
     * Display a listing of the AnimalFeedCategory.
     * GET|HEAD /animalFeedCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $animalFeedCategories = $this->animalFeedCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($animalFeedCategories->toArray(), 'Animal Feed Categories retrieved successfully');
    }

    /**
     * Store a newly created AnimalFeedCategory in storage.
     * POST /animalFeedCategories
     *
     * @param CreateAnimalFeedCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimalFeedCategoryAPIRequest $request)
    {
        $input = $request->all();

        $animalFeedCategory = $this->animalFeedCategoryRepository->create($input);

        return $this->sendResponse($animalFeedCategory->toArray(), 'Animal Feed Category saved successfully');
    }

    /**
     * Display the specified AnimalFeedCategory.
     * GET|HEAD /animalFeedCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AnimalFeedCategory $animalFeedCategory */
        $animalFeedCategory = $this->animalFeedCategoryRepository->find($id);

        if (empty($animalFeedCategory)) {
            return $this->sendError('Animal Feed Category not found');
        }

        return $this->sendResponse($animalFeedCategory->toArray(), 'Animal Feed Category retrieved successfully');
    }

    /**
     * Update the specified AnimalFeedCategory in storage.
     * PUT/PATCH /animalFeedCategories/{id}
     *
     * @param int $id
     * @param UpdateAnimalFeedCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimalFeedCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var AnimalFeedCategory $animalFeedCategory */
        $animalFeedCategory = $this->animalFeedCategoryRepository->find($id);

        if (empty($animalFeedCategory)) {
            return $this->sendError('Animal Feed Category not found');
        }

        $animalFeedCategory = $this->animalFeedCategoryRepository->update($input, $id);

        return $this->sendResponse($animalFeedCategory->toArray(), 'AnimalFeedCategory updated successfully');
    }

    /**
     * Remove the specified AnimalFeedCategory from storage.
     * DELETE /animalFeedCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AnimalFeedCategory $animalFeedCategory */
        $animalFeedCategory = $this->animalFeedCategoryRepository->find($id);

        if (empty($animalFeedCategory)) {
            return $this->sendError('Animal Feed Category not found');
        }

        $animalFeedCategory->delete();

        return $this->sendSuccess('Animal Feed Category deleted successfully');
    }
}
