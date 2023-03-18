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
use App\Models\Address;
use App\Models\Plot;
use App\Models\District;
use App\Models\Category;
use DB;

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
        $cropsOnSale = CropOnSale::where('is_sold',0)->latest()->get(['id','name','image','selling_price','quantity','quantity_unit','price_unit','description','location','is_sold','created_at']);

      //  $data = collect($cropsOnSale);
        //dd($data->min('buying_price'));

        $response = [
            'success'=>true,
            'data'=> [
                'total-crops-on-sale'=>$cropsOnSale->count(),
                'crops-on-sale'=>$cropsOnSale

            ],

            'message'=> 'cropsOnSale retrieved successfully'
         ];
         return response()->json($response,200);
    }

    //crops on sale for a single farmer
    public function famerCropsOnSale(Request $request)
    {
        $cropsOnSale = CropOnSale::with('crop')->where('user_id',auth()->user()->id)->get();

        if($cropsOnSale->count()==0){
            $response = [
                'success'=>false,

                'message'=> 'farmer has no crops posted for sale'
             ];
             return response()->json($response,200);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-crops-on-sale'=>$cropsOnSale->count(),
                    'crops-on-sale'=>$cropsOnSale

                ],

                'message'=> 'farmer crops on sale retrieved successfully'
             ];
             return response()->json($response,200);

        }


    }


    public function home_crops_on_sale(Request $request)
    {
        $crops_on_sale = CropOnSale::where('is_sold',0)->latest()->limit(6)->get();
        $response = [
            'success'=>true,
            'data'=> [
                'total-crops-on-sale'=>$crops_on_sale->count(),
                'crops-on-sale'=>$crops_on_sale

            ],

            'message'=> 'Crops on sale retrieved successfully'
         ];
         return response()->json($response,200);


    }


    public function crop_on_sale_search(Request $request){

        $search = $request->keyword;

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,400);

        }

        $all_crops_on_sale = CropOnSale::where('is_sold',0)->get();
        $crops_on_sale = CropOnSale::where('is_sold',0)->where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();


        if(count($crops_on_sale) == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>count($crops_on_sale)." "."results found out of"." ".count($all_crops_on_sale),
                    'search-results'=>$crops_on_sale,

                ],

                'message'=> 'search results'
              ];
             return response()->json($response,200);

        }



}
    //get crops on sale by crop
    public function crop_on_sale_category(Request $request,$id){

        $crop = Crop::find($id);

        $crops_on_sale = $crop->crops_on_sale;


       //dd($crops_on_sale);
        $response = [
            'success'=>true,
            'data'=>[
                'total-crops-on-sale'=>$crop->crops_on_sale->count(),
                'crops-on-sale'=>$crops_on_sale
            ],
            'message'=> "Crops on sale under " .$crop->name. " retrieved sucessfully"
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

    public function store(Request $request){

        $rules = [
            'quantity' => 'required|integer',
            'selling_price' => 'required|integer',
            'price_unit' => 'nullable',
            'description' => 'required|string|min:20',
            'is_sold' => 'nullable',
            'crop_id' => 'required|integer',
            'address_id' => 'required|integer'
        ];
        $request->validate($rules);
        $location = Address::find($request->address_id);



        $existing_crop = CropOnSale::where('crop_id',$request->crop_id)->where('user_id',auth()->user()->id)->where('is_sold',false)->first();

             if($existing_crop){

               $response = [
                'success'=>false,
                'message'=> 'Crop already posted  for sale '
               ];
              return response()->json($response,400);

             }
             else{

                $location = Address::find($request->address_id);
                $new_crop_on_sale = new CropOnSale();
                $new_crop_on_sale->quantity = $request->quantity;
                $new_crop_on_sale->selling_price = $request->selling_price;
                $new_crop_on_sale->quantity_unit = 'kg';
                $new_crop_on_sale->price_unit = 'UGX';
                $new_crop_on_sale->is_sold = false;

                //crop
                $crop = Crop::find($request->crop_id);
                $new_crop_on_sale->name = $crop->name;
                $new_crop_on_sale->image = $crop->image;
                $new_crop_on_sale->description = $request->description;
                $new_crop_on_sale->location = $location->district_name;
                $new_crop_on_sale->crop_id= $request->crop_id;
                $new_crop_on_sale->user_id= auth()->user()->id;
                //dd($new_crop_on_sale);
                $new_crop_on_sale->save();


                $response = [
                    'success'=>true,
                    'data'=>$new_crop_on_sale,
                    'message'=> 'Crop posted for sale '
                   ];
                  return response()->json($response,200);
             }



    }


    //filter crop on sale by price range
    public function price_range(Request $request){


       if(empty($request->min_price) || empty($request->max_price)){

        $response = [
            'success'=>false,
            'message'=> 'Price range required'
         ];

         return response()->json($response,400);

       }else{

        $price_crops = CropOnSale::select("*")->where('is_sold',0)->whereBetween('selling_price', [$request->min_price, $request->max_price])->get();
        $response = [
            'success'=>true,
            'data'=>[
                'total-results'=>count($price_crops),
                'crops-on-sale'=>$price_crops
            ],
            'message'=> 'Crops on sale between this range retrieved'
         ];

         return response()->json($response,200);
       }




    }

    //filter crops on sale by location
    public function location_crops(Request $request){

        if(empty($request->district_id)){
            $response = [
                'success'=>false,
                'message'=> 'Please select a district'
             ];

             return response()->json($response,400);

        }

        $district= District::find($request->district_id);


        $location_crops = CropOnSale::where('is_sold',0)->where('location',$district->name)->get();
        $all_crops_on_sale = CropOnSale::where('is_sold',0)->get();

        if(count($location_crops) == 0){

            $response = [
                'success'=>false,
                'message'=> 'No results found'
             ];

             return response()->json($response,200);

        }

        else{

          //  dd($location_crops);

            $response = [
                'success'=>false,
                'data'=>[
                    'total-results'=>count($location_crops). " out of ".count($all_crops_on_sale)." crops on sale" ,
                     'crops-on-sale'=>$location_crops
                ],
                'message'=> 'Crops on sale retrieved successfully'
             ];

             return response()->json($response,200);

        }




     }


    //vendpr crop orders/ buy requests

    public function crop_orders(){

        $buy_requests = CropOnSale::where('user_id',auth()->user()->id)->get();
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
        // dd($crop_on_sale->id);

        //get crop buyers
        $buyers = DB::table('crop_on_sales')
                  ->join('crop_orders',"crop_on_sales.id", "=", "crop_orders.crop_on_sale_id")
                  ->leftJoin('users','users.id','=','crop_orders.user_id')
                  ->where('crop_on_sales.id',$crop_on_sale->id)
                  ->select('crop_on_sales.name','crop_orders.buying_price','users.username','crop_orders.location AS buyer-location')
                  ->get();





        if (empty($crop_on_sale)) {
            return $this->sendError('Crop On Sale not found');
        }
        else{
            $success['quantity'] = $crop_on_sale->quantity;
            $success['quantity_unit'] = $crop_on_sale->quantity_unit;
            $success['selling_price'] = $crop_on_sale->selling_price;
            $success['price_unit'] = $crop_on_sale->price_unit;
            $success['crop'] = $crop_on_sale->crop->name;
            $success['location'] = $crop_on_sale->location;
            $success['is-sold'] = $crop_on_sale->is_sold;
            $success['description'] = $crop_on_sale->description;
            $success['created_at'] = $crop_on_sale->created_at->format('d/m/Y');
            $success['time_since'] = $crop_on_sale->created_at->diffForHumans();
            $success['image'] = $crop_on_sale->crop->image;
            $success['farmer'] = $crop_on_sale->user->username;
            $success['total-buyers'] = $crop_on_sale->crop_buy_requests->count();
            $success['maximum-buying-price'] = $buyers->max('buying_price');
            $success['minimum-buying-price'] = $buyers->min('buying_price');
            $success['buyers'] = $buyers;
            // $data = collect($crop_on_sale->crop_buy_requests);


            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Crop on-sale details retrieved successfully'
             ];

             return response()->json($response,200);
        }
    }




    //get crop buy requests for a crop
    public function crop_buy_requests($id)
    {
        /** @var CropOnSale $cropOnSale */
        $crop_on_sale = $this->cropOnSaleRepository->find($id);
        //dd($crop_on_sale->crop_buy_requests);

        if (empty($crop_on_sale)) {
            return $this->sendError('Crop On Sale not found');
        }
        else{

            $buyers = DB::table('crop_on_sales')
            ->join('crop_orders',"crop_on_sales.id", "=", "crop_orders.crop_on_sale_id")
            ->leftJoin('users','users.id','=','crop_orders.user_id')
            ->where('crop_on_sales.id',$crop_on_sale->id)
            ->select('crop_on_sales.name','crop_orders.buying_price','crop_orders.is_accepted','users.username','crop_orders.location AS buyer-location')
            ->get();

            $success['total-buy-requests'] = $buyers->count();
            $success['maximum-buying-price'] = $buyers->max('buying_price');
            $success['minimum-buying-price'] = $buyers->min('buying_price');
            $success['buyers'] = $buyers;


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
