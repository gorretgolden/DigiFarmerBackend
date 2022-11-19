<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSubCategoryAPIRequest;
use App\Http\Requests\API\UpdateSubCategoryAPIRequest;
use App\Models\SubCategory;
use App\Repositories\SubCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SubCategoryController
 * @package App\Http\Controllers\API
 */

class SubCategoryAPIController extends AppBaseController
{
    /** @var  SubCategoryRepository */
    private $subCategoryRepository;

    public function __construct(SubCategoryRepository $subCategoryRepo)
    {
        $this->subCategoryRepository = $subCategoryRepo;
    }

    /**
     * Display a listing of the SubCategory.
     * GET|HEAD /subCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sub_categories = SubCategory::with('category')->get();
        $response = [
            'success'=>true,
            'data'=> $sub_categories,
            'message'=> 'Sub_categories retrieved successfully'
         ];
         return response()->json($response,200);
    }

    /**
     * Store a newly created SubCategory in storage.
     * POST /subCategories
     *
     * @param CreateSubCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSubCategoryAPIRequest $request)
    {
        $input = $request->all();

        $subCategory = $this->subCategoryRepository->create($input);

        return $this->sendResponse($subCategory->toArray(), 'Sub Category saved successfully');
    }

    /**
     * Display the specified SubCategory.
     * GET|HEAD /subCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SubCategory $subCategory */
        $subCategory = $this->subCategoryRepository->find($id);
        $crops = $subCategory->crops;

        if (empty($subCategory)) {
            return $this->sendError('Sub Category not found');
        }
        else{
            $response = [
                'success'=>true,
                'data'=> [
                    'sub_category'=> $subCategory,
                     'crops' => $crops
                ],

                'message'=> 'Sub category details retrieved successfully'
             ];

             return response()->json($response,200);
        }


    }

    /**
     * Update the specified SubCategory in storage.
     * PUT/PATCH /subCategories/{id}
     *
     * @param int $id
     * @param UpdateSubCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var SubCategory $subCategory */
        $subCategory = $this->subCategoryRepository->find($id);

        if (empty($subCategory)) {
            return $this->sendError('Sub Category not found');
        }

        $subCategory = $this->subCategoryRepository->update($input, $id);

        return $this->sendResponse($subCategory->toArray(), 'SubCategory updated successfully');
    }

    /**
     * Remove the specified SubCategory from storage.
     * DELETE /subCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SubCategory $subCategory */
        $subCategory = $this->subCategoryRepository->find($id);

        if (empty($subCategory)) {
            return $this->sendError('Sub Category not found');
        }

        $subCategory->delete();

        return $this->sendSuccess('Sub Category deleted successfully');
    }
}
