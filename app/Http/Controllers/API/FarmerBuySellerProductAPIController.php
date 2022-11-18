<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFarmerBuySellerProductAPIRequest;
use App\Http\Requests\API\UpdateFarmerBuySellerProductAPIRequest;
use App\Models\FarmerBuySellerProduct;
use App\Repositories\FarmerBuySellerProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FarmerBuySellerProductController
 * @package App\Http\Controllers\API
 */

class FarmerBuySellerProductAPIController extends AppBaseController
{
    /** @var  FarmerBuySellerProductRepository */
    private $farmerBuySellerProductRepository;

    public function __construct(FarmerBuySellerProductRepository $farmerBuySellerProductRepo)
    {
        $this->farmerBuySellerProductRepository = $farmerBuySellerProductRepo;
    }

    /**
     * Display a listing of the FarmerBuySellerProduct.
     * GET|HEAD /farmerBuySellerProducts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $farmerBuySellerProducts = $this->farmerBuySellerProductRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($farmerBuySellerProducts->toArray(), 'Farmer Buy Seller Products retrieved successfully');
    }

    /**
     * Store a newly created FarmerBuySellerProduct in storage.
     * POST /farmerBuySellerProducts
     *
     * @param CreateFarmerBuySellerProductAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFarmerBuySellerProductAPIRequest $request)
    {
        $input = $request->all();

        $farmerBuySellerProduct = $this->farmerBuySellerProductRepository->create($input);

        return $this->sendResponse($farmerBuySellerProduct->toArray(), 'Farmer Buy Seller Product saved successfully');
    }

    /**
     * Display the specified FarmerBuySellerProduct.
     * GET|HEAD /farmerBuySellerProducts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FarmerBuySellerProduct $farmerBuySellerProduct */
        $farmerBuySellerProduct = $this->farmerBuySellerProductRepository->find($id);

        if (empty($farmerBuySellerProduct)) {
            return $this->sendError('Farmer Buy Seller Product not found');
        }

        return $this->sendResponse($farmerBuySellerProduct->toArray(), 'Farmer Buy Seller Product retrieved successfully');
    }

    /**
     * Update the specified FarmerBuySellerProduct in storage.
     * PUT/PATCH /farmerBuySellerProducts/{id}
     *
     * @param int $id
     * @param UpdateFarmerBuySellerProductAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFarmerBuySellerProductAPIRequest $request)
    {
        $input = $request->all();

        /** @var FarmerBuySellerProduct $farmerBuySellerProduct */
        $farmerBuySellerProduct = $this->farmerBuySellerProductRepository->find($id);

        if (empty($farmerBuySellerProduct)) {
            return $this->sendError('Farmer Buy Seller Product not found');
        }

        $farmerBuySellerProduct = $this->farmerBuySellerProductRepository->update($input, $id);

        return $this->sendResponse($farmerBuySellerProduct->toArray(), 'FarmerBuySellerProduct updated successfully');
    }

    /**
     * Remove the specified FarmerBuySellerProduct from storage.
     * DELETE /farmerBuySellerProducts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FarmerBuySellerProduct $farmerBuySellerProduct */
        $farmerBuySellerProduct = $this->farmerBuySellerProductRepository->find($id);

        if (empty($farmerBuySellerProduct)) {
            return $this->sendError('Farmer Buy Seller Product not found');
        }

        $farmerBuySellerProduct->delete();

        return $this->sendSuccess('Farmer Buy Seller Product deleted successfully');
    }
}
