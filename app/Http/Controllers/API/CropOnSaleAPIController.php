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
use App\Models\Plot;
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
        $cropsOnSale = CropOnSale::with('user','crop','crop_orders')->get();

      //  $data = collect($cropsOnSale);
        //dd($data->min('buying_price'));

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

    public function store(CreateCropOnSaleAPIRequest $request){

        $existing_crop_on_sale = CropOnSale::where('user_id',$request->user_id)->where('crop_id',$request->crop_id)->first();


        //dd($existing_farmer);

        if($existing_crop_on_sale){

            $response = [
                'success'=>false,
                'message'=> 'Farmer already posted this crop for sale '
             ];
             return response()->json($response,403);

       }

       else
        {
            //for each crop on sale ensure that it exits on a farm plot


           $farmer = User::where('id', auth()->user()->id)->first();

           if ($farmer->farms->count() == 0) {
             // dd('Farmer has no farms');

             $response = [
                'success'=>false,
                'message'=> 'Farmer has no farms '
             ];
             return response()->json($response,404);

           }else{
            foreach ($farmer->farms as $farm){

                if($farm->plots->count() == 0){

                    $response = [
                        'success'=>false,
                        'message'=> 'No plots exit on the farm for this crop '
                     ];
                     return response()->json($response,404);

                }elseif(collect($farm->plots)->contains('crop_id', $request->crop_id)){

                    $data = collect($farm->plots->where('crop_id', $request->crop_id));
                    $plot_harvest = $data->pluck('total_harvest')->toArray()[0];
                    //dd($plot_harvest);
                    $new_crop_on_sale = new CropOnSale();
                    $new_crop_on_sale->quantity = $plot_harvest;
                    $new_crop_on_sale->selling_price = $request->selling_price;
                    $new_crop_on_sale->quantity_unit = 'kg';
                    $new_crop_on_sale->price_unit = 'UGX';
                    $new_crop_on_sale->is_sold = false;
                    $new_crop_on_sale->crop_id= $request->crop_id;
                    $new_crop_on_sale->user_id= auth()->user()->id;
                    $new_crop_on_sale->save();


                    $success['quantity'] = $new_crop_on_sale->quantity;
                    $success['quantity_unit'] = $new_crop_on_sale->quantity_unit;
                    $success['price_unit'] = $new_crop_on_sale->price_unit;
                    $success['selling_price'] = $new_crop_on_sale->selling_price;
                    $success['crop'] = $new_crop_on_sale->crop;
                    $success['farmer'] = $farmer;

                    $response = [
                        'success'=>true,
                        'data'=> $success,
                        'message'=> 'Crop posted for sale successfully'
                     ];

                     return response()->json($response,200);



                }else{


                    $response = [
                        'success'=>false,
                        'message'=> 'Crop selected doesnt exist on the plot '
                     ];
                     return response()->json($response,404);
                }

            }


           }



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
            $success['crop'] = $crop_on_sale->crop;
            $success['farmer'] = $crop_on_sale->user;
            $success['buyers'] = $crop_on_sale->crop_orders;
            $success['total-buyers'] = count($crop_on_sale->crop_orders);
            $data = collect($crop_on_sale->crop_orders);
            //dd($data->min('buying_price'));
            $success['min-price'] = $data->min('buying_price');

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
    public function update($id,Request $request)
    {
        $input = $request->all();
        $request->validate([
            'selling_price'=>'required|integer'
        ]);

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
