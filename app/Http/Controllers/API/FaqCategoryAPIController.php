<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFaqCategoryAPIRequest;
use App\Http\Requests\API\UpdateFaqCategoryAPIRequest;
use App\Models\FaqCategory;
use App\Repositories\FaqCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FaqCategoryController
 * @package App\Http\Controllers\API
 */

class FaqCategoryAPIController extends AppBaseController
{
    /** @var  FaqCategoryRepository */
    private $faqCategoryRepository;

    public function __construct(FaqCategoryRepository $faqCategoryRepo)
    {
        $this->faqCategoryRepository = $faqCategoryRepo;
    }

    /**
     * Display a listing of the FaqCategory.
     * GET|HEAD /faqCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $faqCategories = FaqCategory::all(
        'name','image'
        );

        return $this->sendResponse($faqCategories->toArray(), 'Faq Categories retrieved successfully');
    }

    /**
     * Store a newly created FaqCategory in storage.
     * POST /faqCategories
     *
     * @param CreateFaqCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFaqCategoryAPIRequest $request)
    {
        $input = $request->all();

        $faqCategory = $this->faqCategoryRepository->create($input);

        return $this->sendResponse($faqCategory->toArray(), 'Faq Category saved successfully');
    }

    /**
     * Display the specified FaqCategory.
     * GET|HEAD /faqCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FaqCategory $faqCategory */
        $faqCategory = $this->faqCategoryRepository->find($id);

        if (empty($faqCategory)) {
            return $this->sendError('Faq Category not found');
        }

        return $this->sendResponse($faqCategory->toArray(), 'Faq Category retrieved successfully');
    }

    /**
     * Update the specified FaqCategory in storage.
     * PUT/PATCH /faqCategories/{id}
     *
     * @param int $id
     * @param UpdateFaqCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFaqCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var FaqCategory $faqCategory */
        $faqCategory = $this->faqCategoryRepository->find($id);

        if (empty($faqCategory)) {
            return $this->sendError('Faq Category not found');
        }

        $faqCategory = $this->faqCategoryRepository->update($input, $id);

        return $this->sendResponse($faqCategory->toArray(), 'FaqCategory updated successfully');
    }

    /**
     * Remove the specified FaqCategory from storage.
     * DELETE /faqCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FaqCategory $faqCategory */
        $faqCategory = $this->faqCategoryRepository->find($id);

        if (empty($faqCategory)) {
            return $this->sendError('Faq Category not found');
        }

        $faqCategory->delete();

        return $this->sendSuccess('Faq Category deleted successfully');
    }
}
