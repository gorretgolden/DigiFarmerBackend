<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCropOnSaleAPIRequest;
use App\Http\Requests\API\UpdateCropOnSaleAPIRequest;
use App\Models\CropOnSale;
use App\Repositories\CropOnSaleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;
use App\Models\Crop;

/**
 * Class CropOnSaleController
 * @package App\Http\Controllers\API
 */

class CropOnSaleAPIController extends AppBaseController
{
    /** @var  CropOnSaleRepository */
    private $cropOnSaleRepository;

    public function __construct(CropOnSaleRepository $cropOnSaleRepo)
    {
        $this->cropOnSaleRepository = $cropOnSaleRepo;
    }

    /**
     * Display a listing of the CropOnSale.
     * GET|HEAD /cropOnSales
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $cropsOnSale = CropOnSale::with('user','crop','crop_buyers')->get();
        $response = [
            'success'=>true,
            'data'=> $cropsOnSale,
            'message'=> 'cropsOnSale retrieved successfully'
         ];
         return response()->json($response,200);
    }

    /**
     * Store a newly created CropOnSale in storage.
     * POST /cropOnSales
     *
     * @param CreateCropOnSaleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCropOnSaleAPIRequest $request)
    {


         $existing_farmer = CropOnSale::where('user_id',auth()->user()->id)->first();
         $existing_crop = CropOnSale::where('crop_id',$request->crop_id)->first();

         if($existing_farmer && $existing_crop){

            $response = [
                'success'=>false,
                'message'=> 'Crop  already on sale '
             ];
             return response()->json($response,403);
        }

        else
        {

            $crop_on_sale = new CropOnSale();
            $crop_on_sale->quantity = $request->quantity;
            $crop_on_sale->quantity_unit = $request->quantity_unit;
            $crop_on_sale->price_unit = $request->price_unit;
            $crop_on_sale->selling_price = $request->selling_price;
            $crop_on_sale->description = $request->description;
            $crop_on_sale->image = $request->image;
            $crop_on_sale->crop_id = $request->crop_id;
            $crop_on_sale->user_id = auth()->user()->id;
             $crop_on_sale->save();

             $success['quantity'] = $crop_on_sale->quantity;
             $success['quantity_unit'] = $crop_on_sale->quantity_unit;
             $success['price_unit'] = $crop_on_sale->price_unit;
             $success['selling_price'] = $crop_on_sale->selling_price;
             $success['description'] = $crop_on_sale->description;
             $success['crop'] = $crop_on_sale->crop;
             $success['image'] = $crop_on_sale->image;
             $success['farmer'] = $crop_on_sale->user;

             $crop_on_sale = CropOnSale::find($crop_on_sale->id);

             $crop_on_sale->image = \App\Models\ImageUploader::upload($request->file('image'),'crops_on_sale');
             $crop_on_sale->save();

             $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Crop posted for sale'
             ];

             return response()->json($response,200);
        }
    }

    /**
     * Display the specified CropOnSale.
     * GET|HEAD /cropOnSales/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CropOnSale $cropOnSale */
        $crop_on_sale = $this->cropOnSaleRepository->find($id);

        if (empty($crop_on_sale)) {
            return $this->sendError('Crop On Sale not found');
        }
        else{
            $success['quantity'] = $crop_on_sale->quantity;
            $success['quantity_unit'] = $crop_on_sale->quantity_unit;
            $success['selling_price'] = $crop_on_sale->selling_price;
            $success['price_unit'] = $crop_on_sale->price_unit;
            $success['image'] = $crop_on_sale->image;
            $success['description'] = $crop_on_sale->description;
            $success['crop'] = $crop_on_sale->crop;
            $success['farmer'] = $crop_on_sale->user;

            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Crop on-sale details retrieved successfully'
             ];

             return response()->json($response,200);
        }
    }

    /**
     * Update the specified CropOnSale in storage.
     * PUT/PATCH /cropOnSales/{id}
     *
     * @param int $id
     * @param UpdateCropOnSaleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropOnSaleAPIRequest $request)
    {
        $input = $request->all();

        /** @var CropOnSale $cropOnSale */
        $cropOnSale = $this->cropOnSaleRepository->find($id);

        if (empty($cropOnSale)) {
            return $this->sendError('Crop On Sale not found');
        }

        $cropOnSale = $this->cropOnSaleRepository->update($input, $id);

        return $this->sendResponse($cropOnSale->toArray(), 'CropOnSale updated successfully');
    }

    /**
     * Remove the specified CropOnSale from storage.
     * DELETE /cropOnSales/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CropOnSale $cropOnSale */
        $cropOnSale = $this->cropOnSaleRepository->find($id);

        if (empty($cropOnSale)) {
            return $this->sendError('Crop On Sale not found');
        }

        $cropOnSale->delete();

        return $this->sendSuccess('Crop On Sale deleted successfully');
    }
}
