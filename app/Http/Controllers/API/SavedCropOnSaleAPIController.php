<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSavedCropOnSaleAPIRequest;
use App\Http\Requests\API\UpdateSavedCropOnSaleAPIRequest;
use App\Models\SavedCropOnSale;
use App\Repositories\SavedCropOnSaleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SavedCropOnSaleController
 * @package App\Http\Controllers\API
 */

class SavedCropOnSaleAPIController extends AppBaseController
{
    /** @var  SavedCropOnSaleRepository */
    private $savedCropOnSaleRepository;

    public function __construct(SavedCropOnSaleRepository $savedCropOnSaleRepo)
    {
        $this->savedCropOnSaleRepository = $savedCropOnSaleRepo;
    }

    /**
     * Display a listing of the SavedCropOnSale.
     * GET|HEAD /savedCropOnSales
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $savedCropOnSales = $this->savedCropOnSaleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($savedCropOnSales->toArray(), 'Saved Crop On Sales retrieved successfully');
    }

    /**
     * Store a newly created SavedCropOnSale in storage.
     * POST /savedCropOnSales
     *
     * @param CreateSavedCropOnSaleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSavedCropOnSaleAPIRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $saved_crop = SavedCropOnSale::where('crop_on_sale_id',$request->crop_on_sale_id)->where('user_id',auth()->user()->id)->first();
        if($saved_crop){
            $response = [
                'success'=>false,
                'message'=> 'Crop already saved'
             ];

             return response()->json($response,200);
        }

        $savedCropOnSale = $this->savedCropOnSaleRepository->create($input);

        return $this->sendResponse($savedCropOnSale->toArray(), 'Crop On Sale saved successfully');
    }

    /**
     * Display the specified SavedCropOnSale.
     * GET|HEAD /savedCropOnSales/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SavedCropOnSale $savedCropOnSale */
        $savedCropOnSale = $this->savedCropOnSaleRepository->find($id);

        if (empty($savedCropOnSale)) {
            return $this->sendError('Saved Crop On Sale not found');
        }

        return $this->sendResponse($savedCropOnSale->toArray(), 'Saved Crop On Sale retrieved successfully');
    }

    //get farmer saved crops on sale
    public function saved_crops()
    {

        $saved_crops = SavedCropOnSale::with('crop_on_sale')->where('user_id',auth()->user()->id)->get() ;

        if (count($saved_crops) == 0) {

            $response = [
                'success'=>false,
                'message'=> 'No crops saved'
              ];
             return response()->json($response,200);

        }else{

            $response = [
                'success'=>true,
                'data'=>[
                    'total-saved-crops'=>count($saved_crops),
                    'crops-on-sale'=>$saved_crops
                ],
                'message'=> 'Saved Crops On Sale retrieved successfully'
              ];
             return response()->json($response,200);
        }



    }

    /**
     * Update the specified SavedCropOnSale in storage.
     * PUT/PATCH /savedCropOnSales/{id}
     *
     * @param int $id
     * @param UpdateSavedCropOnSaleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSavedCropOnSaleAPIRequest $request)
    {
        $input = $request->all();

        /** @var SavedCropOnSale $savedCropOnSale */
        $savedCropOnSale = $this->savedCropOnSaleRepository->find($id);

        if (empty($savedCropOnSale)) {
            return $this->sendError('Saved Crop On Sale not found');
        }

        $savedCropOnSale = $this->savedCropOnSaleRepository->update($input, $id);

        return $this->sendResponse($savedCropOnSale->toArray(), 'SavedCropOnSale updated successfully');
    }

    /**
     * Remove the specified SavedCropOnSale from storage.
     * DELETE /savedCropOnSales/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SavedCropOnSale $savedCropOnSale */
        $savedCropOnSale = $this->savedCropOnSaleRepository->find($id);

        if (empty($savedCropOnSale)) {
            return $this->sendError('Saved Crop On Sale not found');
        }

        $savedCropOnSale->delete();

        return $this->sendSuccess('Saved Crop On Sale deleted successfully');
    }
}
