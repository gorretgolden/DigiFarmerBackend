<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCropBuyerAPIRequest;
use App\Http\Requests\API\UpdateCropBuyerAPIRequest;
use App\Models\CropBuyer;
use App\Repositories\CropBuyerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CropBuyerCropOnSale;
use App\Models\CropOnSale;
use App\Models\User;

/**
 * Class CropBuyerController
 * @package App\Http\Controllers\API
 */

class CropOrderAPIController extends AppBaseController
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
        $cropBuyers = CropBuyer::with('user')->get();
        $response = [
            'success'=>true,
            'data'=> $cropBuyers,
            'message'=> 'Crop Buyers retrieved successfully'
         ];
         return response()->json($response,200);

        return $this->sendResponse($cropBuyers->toArray(), 'Crop Buyers retrieved successfully');
    }


    //Orders View Function
   public function viewOrders(User $user)
 {
    $crops_on_sale = CropOnSale::where('user_id', '=', $user->id)->get();
    $crop_orders = [];
    foreach($crops_on_sale as $crops_on_sale){
        array_merge($crop_orders, $crop->corder);
    }
    //dd( $products);
    return view('orders')->with(compact('orders'));
}
    /**
     * Store a newly created CropBuyer in storage.
     * POST /cropBuyers
     *
     * @param CreateCropBuyerAPIRequest $request
     *
     * @return Response
     */


     public function getCropBuyerCropOnSales (Request $request){
        $buyer_user_id = CropBuyer::where('user_id',auth()->user()->id)->get();

        $response = [
            'success'=>false,
            'data' => $buyer_user_id,
            'message'=> 'You already sent a buy request for this crop '
         ];
         return response()->json($response,403);
     }


    public function buyCropOnSale(CreateCropBuyerAPIRequest $request, $id)
    {


        $existing_buyer = CropBuyer::where('user_id',auth()->user()->id)->first();
        $existing_crop = CropBuyerCropOnSale::where('crop_on_sale_id',$id)->first();

        if($existing_buyer && $existing_crop ){

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
        $crop_buyer->user_id = auth()->user()->id;
        $crop_buyer->save();

        $crop = CropOnSale::find($id);
        $crop_buyer->crops_on_sale()->attach($crop);
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


         $buyer_user_id = CropBuyer::where('user_id',auth()->user()->id)->get();
         //  dd($buyer_user_id);
        // $buyer_crops = $buyer_user_id->crops_on_sale;
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
        else{
            $success['id'] = $cropBuyer->id;
            $success['buying_price'] = $cropBuyer->buying_price;
            $success['has_bought'] = $cropBuyer->has_bought;
            $success['contact_one'] = $cropBuyer->contact_one;
            $success['email'] = $cropBuyer->email;
            $success['description'] = $cropBuyer->description;
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
