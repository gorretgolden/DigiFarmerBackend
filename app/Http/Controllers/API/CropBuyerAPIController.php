<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCropBuyerAPIRequest;
use App\Http\Requests\API\UpdateCropBuyerAPIRequest;
use App\Models\CropBuyer;
use App\Repositories\CropBuyerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CropBuyerController
 * @package App\Http\Controllers\API
 */

class CropBuyerAPIController extends AppBaseController
{
    /** @var  CropBuyerRepository */
    private $cropBuyerRepository;

    public function __construct(CropBuyerRepository $cropBuyerRepo)
    {
        $this->cropBuyerRepository = $cropBuyerRepo;
    }

    /**
     * Display a listing of the CropBuyer.
     * GET|HEAD /cropBuyers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $cropBuyers = $this->cropBuyerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($cropBuyers->toArray(), 'Crop Buyers retrieved successfully');
    }

    /**
     * Store a newly created CropBuyer in storage.
     * POST /cropBuyers
     *
     * @param CreateCropBuyerAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCropBuyerAPIRequest $request)
    {
        $existing_buyer = CropBuyer::where('user_id',auth()->user()->id)->first();
        $existing_crop = CropBuyer::where('crop_on_sale_id',$request->crop_on_sale_id)->first();

        if($existing_buyer && $existing_crop){

            $response = [
                'success'=>false,
                'message'=> 'You already sent a buy request for this crop '
             ];
             return response()->json($response,403);
        }
        else{


        $crop_buyer = new CropBuyer();
        $crop_buyer->contact_one = $request->contact_one;
        $crop_buyer->contact_two = $request->contact_two;
        $crop_buyer->email = $request->email;
        $crop_buyer->buying_price = $request->buying_price;
        $crop_buyer->description = $request->description;
        $crop_buyer->crop_on_sale_id = $request->crop_on_sale_id;
        $crop_buyer->user_id = auth()->user()->id;
        $crop_buyer->save();

         $success['buying_price'] = $crop_buyer->buying_price;
         $success['has_bought'] = false;
         $success['is_accepted'] = false;
         $success['contact_one'] = $crop_buyer->contact_one;
         $success['description'] = $crop_buyer->description;
         $success['crop'] = $crop_buyer->crops;
         $success['contact_two'] = $crop_buyer->contact_two;
         $success['email'] = $crop_buyer->email;
         $success['buyer'] = auth()->user();


         $response = [
            'success'=>true,
            'data'=> $success,
            'message'=> 'Crop Buying request sent to farmer'
         ];

         return response()->json($response,200);
        }


    }

    /**
     * Display the specified CropBuyer.
     * GET|HEAD /cropBuyers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CropBuyer $cropBuyer */
        $cropBuyer = $this->cropBuyerRepository->find($id);

        if (empty($cropBuyer)) {
            return $this->sendError('Crop Buyer not found');
        }

        return $this->sendResponse($cropBuyer->toArray(), 'Crop Buyer retrieved successfully');
    }

    /**
     * Update the specified CropBuyer in storage.
     * PUT/PATCH /cropBuyers/{id}
     *
     * @param int $id
     * @param UpdateCropBuyerAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropBuyerAPIRequest $request)
    {
        $input = $request->all();

        /** @var CropBuyer $cropBuyer */
        $cropBuyer = $this->cropBuyerRepository->find($id);

        if (empty($cropBuyer)) {
            return $this->sendError('Crop Buyer not found');
        }

        $cropBuyer = $this->cropBuyerRepository->update($input, $id);

        return $this->sendResponse($cropBuyer->toArray(), 'CropBuyer updated successfully');
    }

    /**
     * Remove the specified CropBuyer from storage.
     * DELETE /cropBuyers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CropBuyer $cropBuyer */
        $cropBuyer = $this->cropBuyerRepository->find($id);

        if (empty($cropBuyer)) {
            return $this->sendError('Crop Buyer not found');
        }

        $cropBuyer->delete();

        return $this->sendSuccess('Crop Buyer deleted successfully');
    }
}
