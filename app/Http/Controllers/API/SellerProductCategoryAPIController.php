<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSellerProductCategoryAPIRequest;
use App\Http\Requests\API\UpdateSellerProductCategoryAPIRequest;
use App\Models\SellerProductCategory;
use App\Repositories\SellerProductCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SellerProductCategoryController
 * @package App\Http\Controllers\API
 */

class SellerProductCategoryAPIController extends AppBaseController
{
    /** @var  SellerProductCategoryRepository */
    private $sellerProductCategoryRepository;

    public function __construct(SellerProductCategoryRepository $sellerProductCategoryRepo)
    {
        $this->sellerProductCategoryRepository = $sellerProductCategoryRepo;
    }

    /**
     * Display a listing of the SellerProductCategory.
     * GET|HEAD /sellerProductCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sellerProductCategories = SellerProductCategory::orderBy('name','ASC')->get(['id','name','image']);

        return $this->sendResponse($sellerProductCategories->toArray(), 'Seller Product Categories retrieved successfully');
    }

    /**
     * Store a newly created SellerProductCategory in storage.
     * POST /sellerProductCategories
     *
     * @param CreateSellerProductCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSellerProductCategoryAPIRequest $request)
    {
        $input = $request->all();

        $sellerProductCategory = $this->sellerProductCategoryRepository->create($input);

        return $this->sendResponse($sellerProductCategory->toArray(), 'Seller Product Category saved successfully');
    }

    /**
     * Display the specified SellerProductCategory.
     * GET|HEAD /sellerProductCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SellerProductCategory $sellerProductCategory */
        $sellerProductCategory = $this->sellerProductCategoryRepository->find($id);

        if (empty($sellerProductCategory)) {
            return $this->sendError('Seller Product Category not found');
        }

        return $this->sendResponse($sellerProductCategory->toArray(), 'Seller Product Category retrieved successfully');
    }

    //get seller products from category
    public function seller_products($id)
    {
        $sellerProductCategory = SellerProductCategory::find($id);
        //dd($sellerProductCategory);

        if(empty($sellerProductCategory)) {
            $response = [
                'success'=>false,
                'message'=> 'Farm equipment category not found'
             ];

             return response()->json($response,404);

        }elseif(count($sellerProductCategory->seller_products) == 0){
            $response = [
                'success'=>false,
                'message'=> "No farm equipments found under category ".$sellerProductCategory->name
             ];

             return response()->json($response,404);


        }
        else{

            $response = [
                'success'=>true,
                'data'=>[
                    'total-farm-equipments'=>count($sellerProductCategory->seller_products),
                    'category'=>$sellerProductCategory->name,
                    'farm-equipments'=>$sellerProductCategory->seller_products
                ],
                'message'=> "Seller products under ".$sellerProductCategory->name." retrieved successfully"
             ];

             return response()->json($response,200);
        }




    }

    /**
     * Update the specified SellerProductCategory in storage.
     * PUT/PATCH /sellerProductCategories/{id}
     *
     * @param int $id
     * @param UpdateSellerProductCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSellerProductCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var SellerProductCategory $sellerProductCategory */
        $sellerProductCategory = $this->sellerProductCategoryRepository->find($id);

        if (empty($sellerProductCategory)) {
            return $this->sendError('Seller Product Category not found');
        }

        $sellerProductCategory = $this->sellerProductCategoryRepository->update($input, $id);

        return $this->sendResponse($sellerProductCategory->toArray(), 'SellerProductCategory updated successfully');
    }

    /**
     * Remove the specified SellerProductCategory from storage.
     * DELETE /sellerProductCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SellerProductCategory $sellerProductCategory */
        $sellerProductCategory = $this->sellerProductCategoryRepository->find($id);

        if (empty($sellerProductCategory)) {
            return $this->sendError('Seller Product Category not found');
        }

        $sellerProductCategory->delete();

        return $this->sendSuccess('Seller Product Category deleted successfully');
    }
}
