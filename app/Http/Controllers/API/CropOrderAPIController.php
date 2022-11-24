<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCropOrderAPIRequest;
use App\Http\Requests\API\UpdateCropOrderAPIRequest;
use App\Models\CropOrder;
use App\Repositories\CropOrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CropOrderCropOnSale;
use App\Models\CropOnSale;
use App\Models\User;

/**
 * Class CropOrderController
 * @package App\Http\Controllers\API
 */

class CropOrderAPIController extends AppBaseController
{
    /** @var  CropOrderRepository */
    private $cropOrderRepository;

    public function __construct(CropOrderRepository $cropOrderRepo)
    {
        $this->cropOrderRepository = $cropOrderRepo;
    }

    /**
     * Display a listing of the CropOrder.
     * GET|HEAD /cropOrders
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $cropOrders = $this->cropOrderRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($cropOrders->toArray(), 'Crop Orders retrieved successfully');
    }

    /**
     * Store a newly created CropOrder in storage.
     * POST /cropOrders
     *
     * @param CreateCropOrderAPIRequest $request
     *
     * @return Response
     */
    public function buyCropOnSale(CreateCropOrderAPIRequest $request, $id)
    {


        $existing_buyer = CropOrder::where('user_id',auth()->user()->id)->first();
        $existing_crop = CropOrderCropOnSale::where('crop_on_sale_id',$id)->first();

        if($existing_buyer && $existing_crop ){

            $response = [
                'success'=>false,
                'message'=> 'You already sent a buy request for this crop '
             ];
             return response()->json($response,403);
        }
        else{


        $crop_buyer = new CropOrder();
        $crop_buyer->buying_price = $request->buying_price;
        $crop_buyer->user_id = auth()->user()->id;
        $crop_buyer->save();

        $crop = CropOnSale::find($id);

        $crop_buyer->crops_on_sale()->attach($crop);
        $crop_buyer->save();

         $success['buying_price'] = $crop_buyer->buying_price;
         $success['has_bought'] = false;
         $success['is_accepted'] = false;
         $success['crop'] = $crop_buyer->crops;
         $success['buyer'] = auth()->user();


         $buyer_user_id = CropOrder::where('user_id',auth()->user()->id)->get();
         $crops_to_the_buyer = CropOrder::where('user_id',auth()->user()->id)->first();

         $buyer_crops = $crops_to_the_buyer->crops_on_sale;
         $response = [
            'success'=>true,
            'data'=> [
                'success'=>$success,
                'buyer crops'=>$buyer_crops
            ],

            'message'=> 'Crop Buying request sent to farmer'
         ];

         return response()->json($response,200);
        }


    }



    /**
     * Display the specified CropOrder.
     * GET|HEAD /cropOrders/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
         /** @var CropOrder $cropBuyer */
         $cropBuyer = $this->cropBuyerRepository->find($id);

         if (empty($cropBuyer)) {
             return $this->sendError('Crop Buyer not found');
         }
         else{
             $success['id'] = $cropBuyer->id;
             $success['buying_price'] = $cropBuyer->buying_price;
             $success['has_bought'] = $cropBuyer->has_bought;
             $success['is_accepted'] = $cropBuyer->is_accepted;
             $success['user_id'] = $cropBuyer->user;
             $success['crop'] = $cropBuyer->crops_on_sale;
             $success['created_at'] = $cropBuyer->created_at;

             $response = [
                 'success'=>true,
                 'data'=> $success,
                 'message'=> 'Crop details retrieved successfully'
              ];

              return response()->json($response,200);
         }

    }

    /**
     * Update the specified CropOrder in storage.
     * PUT/PATCH /cropOrders/{id}
     *
     * @param int $id
     * @param UpdateCropOrderAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropOrderAPIRequest $request)
    {
        $input = $request->all();

        /** @var CropOrder $cropOrder */
        $cropOrder = $this->cropOrderRepository->find($id);

        if (empty($cropOrder)) {
            return $this->sendError('Crop Order not found');
        }

        $cropOrder = $this->cropOrderRepository->update($input, $id);

        return $this->sendResponse($cropOrder->toArray(), 'CropOrder updated successfully');
    }

    /**
     * Remove the specified CropOrder from storage.
     * DELETE /cropOrders/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CropOrder $cropOrder */
        $cropOrder = $this->cropOrderRepository->find($id);

        if (empty($cropOrder)) {
            return $this->sendError('Crop Order not found');
        }

        $cropOrder->delete();

        return $this->sendSuccess('Crop Order deleted successfully');
    }
}
