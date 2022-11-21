<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCropBuyerCropOnSaleAPIRequest;
use App\Http\Requests\API\UpdateCropBuyerCropOnSaleAPIRequest;
use App\Models\CropBuyerCropOnSale;
use App\Repositories\CropBuyerCropOnSaleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CropBuyerCropOnSaleController
 * @package App\Http\Controllers\API
 */

class CropBuyerCropOnSaleAPIController extends AppBaseController
{
    /** @var  CropBuyerCropOnSaleRepository */
    private $cropBuyerCropOnSaleRepository;

    public function __construct(CropBuyerCropOnSaleRepository $cropBuyerCropOnSaleRepo)
    {
        $this->cropBuyerCropOnSaleRepository = $cropBuyerCropOnSaleRepo;
    }

    /**
     * Display a listing of the CropBuyerCropOnSale.
     * GET|HEAD /cropBuyerCropOnSales
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $cropBuyerCropOnSales = $this->cropBuyerCropOnSaleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($cropBuyerCropOnSales->toArray(), 'Crop Buyer Crop On Sales retrieved successfully');
    }

    /**
     * Store a newly created CropBuyerCropOnSale in storage.
     * POST /cropBuyerCropOnSales
     *
     * @param CreateCropBuyerCropOnSaleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCropBuyerCropOnSaleAPIRequest $request)
    {
        $input = $request->all();

        $cropBuyerCropOnSale = $this->cropBuyerCropOnSaleRepository->create($input);

        return $this->sendResponse($cropBuyerCropOnSale->toArray(), 'Crop Buyer Crop On Sale saved successfully');
    }

    /**
     * Display the specified CropBuyerCropOnSale.
     * GET|HEAD /cropBuyerCropOnSales/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CropBuyerCropOnSale $cropBuyerCropOnSale */
        $cropBuyerCropOnSale = $this->cropBuyerCropOnSaleRepository->find($id);

        if (empty($cropBuyerCropOnSale)) {
            return $this->sendError('Crop Buyer Crop On Sale not found');
        }

        return $this->sendResponse($cropBuyerCropOnSale->toArray(), 'Crop Buyer Crop On Sale retrieved successfully');
    }

    /**
     * Update the specified CropBuyerCropOnSale in storage.
     * PUT/PATCH /cropBuyerCropOnSales/{id}
     *
     * @param int $id
     * @param UpdateCropBuyerCropOnSaleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropBuyerCropOnSaleAPIRequest $request)
    {
        $input = $request->all();

        /** @var CropBuyerCropOnSale $cropBuyerCropOnSale */
        $cropBuyerCropOnSale = $this->cropBuyerCropOnSaleRepository->find($id);

        if (empty($cropBuyerCropOnSale)) {
            return $this->sendError('Crop Buyer Crop On Sale not found');
        }

        $cropBuyerCropOnSale = $this->cropBuyerCropOnSaleRepository->update($input, $id);

        return $this->sendResponse($cropBuyerCropOnSale->toArray(), 'CropBuyerCropOnSale updated successfully');
    }

    /**
     * Remove the specified CropBuyerCropOnSale from storage.
     * DELETE /cropBuyerCropOnSales/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CropBuyerCropOnSale $cropBuyerCropOnSale */
        $cropBuyerCropOnSale = $this->cropBuyerCropOnSaleRepository->find($id);

        if (empty($cropBuyerCropOnSale)) {
            return $this->sendError('Crop Buyer Crop On Sale not found');
        }

        $cropBuyerCropOnSale->delete();

        return $this->sendSuccess('Crop Buyer Crop On Sale deleted successfully');
    }
}
