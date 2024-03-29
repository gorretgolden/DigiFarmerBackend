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
use App\Models\Address;
use DB;

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




        $crop_on_sale = CropOnSale::find($id);

        if (empty($crop_on_sale)) {
            return $this->sendError('Crop on sale not found');
        }

        $existing_buy_request = CropOrder::where('user_id',auth()->user()->id)->where('crop_on_sale_id',$id)->where('is_accepted',false)->first();


        $accepted_buy_request = CropOrder::where('user_id',auth()->user()->id)->where('crop_on_sale_id',$id)->where('is_accepted',true)->first();

        if($existing_buy_request ){

            $response = [
                'success'=>false,
                'message'=> 'You already sent a buy request for this crop '
             ];
             return response()->json($response,409);
        }
        elseif($accepted_buy_request){

            $response = [
                'success'=>false,
                'message'=> 'Your buy request was accepted, proceed to payments'
             ];
             return response()->json($response,400);

        }else{


           $crop_buy_request = new CropOrder();
           $crop_buy_request->buying_price = $request->buying_price;
           $crop_buy_request->user_id = auth()->user()->id;
           $crop_buy_request->crop_on_sale_id = $request->crop_on_sale_id;

           //user address
           $address = Address::find($request->address_id);
           $crop_buy_request->location = $address->district_name;
           $crop_buy_request->save();


           $success['buying_price'] = $crop_buy_request->buying_price;
           $success['location'] = $crop_buy_request->location;
           $success['has_bought'] = false;
           $success['is_accepted'] = false;
           $success['buyer'] = auth()->user()->username;

           $response = [
              'success'=>true,
                'data'=> $success,
            'message'=> 'Crop Buy request sent to farmer'
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

     public function accept_crop_order($id)
     {
          $crop_request = CropOrder::find($id);

          if (empty($crop_request)) {
            $response = [
                'success'=>false,
                'message'=> 'Crop buy request not found'
           ];
         }
         else{

            $crop_request->is_accepted = 1;
            $crop_request->save();

              $response = [
                   'success'=>true,
                   'message'=> 'Crop buy requested has been accepted'
              ];

              return response()->json($response,200);

         }



     }



     //crop buy requests for a user


    public function user_crop_buy_requests(){
        $buy_requests = DB::table('crop_orders')
                        ->join('users','users.id','=','crop_orders.user_id')
                        ->leftJoin('crop_on_sales','crop_on_sales.user_id','=','crop_orders.user_id')
                        ->where('crop_orders.user_id',auth()->user()->id)
                        ->select('crop_on_sales.image','crop_on_sales.name','crop_on_sales.quantity','crop_on_sales.quantity_unit','crop_on_sales.location','crop_on_sales.price_unit','crop_on_sales.selling_price','crop_on_sales.description','crop_orders.buying_price','crop_orders.location AS buyer-location','crop_orders.is_accepted','users.username')
                        ->get();



        if(count($buy_requests) == 0){
            $response = [
                'success'=>false,
                'message'=> "You haven't sent any crop buy requests"
                    ];

                return response()->json($response,404);


        }

        $success['buyers-requests'] = $buy_requests;

        $response = [
            'success'=>true,
            'data'=> $success,
            'message'=> 'Crop buy requests retrieved successfully'
                ];

            return response()->json($response,200);



    }

    //farmer crop requests
    public function farmer_crop_buy_requests(){
        $buy_requests = DB::table('crop_orders')
                        ->join('users','users.id','=','crop_orders.user_id')
                        ->leftJoin('crop_on_sales','crop_on_sales.user_id','=','crop_orders.user_id')
                        ->where('crop_on_sales.user_id',auth()->user()->id)
                        ->select('crop_on_sales.image','crop_on_sales.name','crop_on_sales.quantity','crop_on_sales.quantity_unit','crop_on_sales.location','crop_on_sales.price_unit','crop_on_sales.selling_price','crop_on_sales.description','crop_orders.buying_price','crop_orders.location AS buyer-location','crop_orders.is_accepted','users.username')
                        ->get();



        if(count($buy_requests) == 0){
            $response = [
                'success'=>false,
                'message'=> "You haven't received any crop requests"
                    ];

                return response()->json($response,404);


        }

        $success['buyer-requests'] = $buy_requests;

        $response = [
            'success'=>true,
            'data'=> $success,
            'message'=> 'Crop buy requests retrieved successfully'
                ];

            return response()->json($response,200);



    }



    public function show($id)
    {
         /** @var CropOrder $cropBuyer */
         $cropBuyer = CropOrder::find($id);

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
