<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSellerProductAPIRequest;
use App\Http\Requests\API\UpdateSellerProductAPIRequest;
use App\Models\SellerProduct;
use App\Repositories\SellerProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SellerProductController
 * @package App\Http\Controllers\API
 */

class SellerProductAPIController extends AppBaseController
{
    /** @var  SellerProductRepository */
    private $sellerProductRepository;

    public function __construct(SellerProductRepository $sellerProductRepo)
    {
        $this->sellerProductRepository = $sellerProductRepo;
    }

    /**
     * Display a listing of the SellerProduct.
     * GET|HEAD /sellerProducts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sellerProducts = $this->sellerProductRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($sellerProducts->toArray(), 'Seller Products retrieved successfully');
    }

    /**
     * Store a newly created SellerProduct in storage.
     * POST /sellerProducts
     *
     * @param CreateSellerProductAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSellerProductAPIRequest $request)
    {
        $input = $request->all();

        $sellerProduct = $this->sellerProductRepository->create($input);

        return $this->sendResponse($sellerProduct->toArray(), 'Seller Product saved successfully');
    }

    /**
     * Display the specified SellerProduct.
     * GET|HEAD /sellerProducts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SellerProduct $sellerProduct */
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            return $this->sendError('Seller Product not found');
        }

        return $this->sendResponse($sellerProduct->toArray(), 'Seller Product retrieved successfully');
    }

    /**
     * Update the specified SellerProduct in storage.
     * PUT/PATCH /sellerProducts/{id}
     *
     * @param int $id
     * @param UpdateSellerProductAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSellerProductAPIRequest $request)
    {
        $input = $request->all();

        /** @var SellerProduct $sellerProduct */
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            return $this->sendError('Seller Product not found');
        }

        $sellerProduct = $this->sellerProductRepository->update($input, $id);

        return $this->sendResponse($sellerProduct->toArray(), 'SellerProduct updated successfully');
    }

    /**
     * Remove the specified SellerProduct from storage.
     * DELETE /sellerProducts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SellerProduct $sellerProduct */
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            return $this->sendError('Seller Product not found');
        }

        $sellerProduct->delete();

        return $this->sendSuccess('Seller Product deleted successfully');
    }
}
