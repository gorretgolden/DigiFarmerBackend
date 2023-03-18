<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSellerProductAPIRequest;
use App\Http\Requests\API\UpdateSellerProductAPIRequest;
use App\Models\SellerProduct;
use App\Repositories\SellerProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\VendorCategory;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\File;
use App\Models\District;

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
        $sellerProducts = SellerProduct::where('is_verified',1)->where('status','on-sale')->latest()->get();
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
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|unique:seller_products',
            'description' => 'required|string|min:10',
            'price' => 'required|integer',
            'seller_product_category_id' => 'required|integer',
            'image' => 'required',
            'address_id'=>'required|integer',
            'stock_amount'=>'required|integer'
        ];
        $request->validate($rules);

        $vendor_category = VendorCategory::where('name','Farm Equipments')->first();

        $new_farm_product = new SellerProduct();
        $new_farm_product->name = $request->name;
        $new_farm_product->price = $request->price;
        $new_farm_product->price_unit = "UGX";
        $new_farm_product->status = "on-sale";
        $new_farm_product->image = $request->image;
        $new_farm_product->stock_amount = $request->stock_amount;


        $user = User::find(auth()->user()->id);
        if(!$user->is_vendor ==1){
         $user->is_vendor = 1;
         $user->save();
        }

        $new_farm_product->user_id = auth()->user()->id;
        $new_farm_product->vendor_category_id = $vendor_category->id;
        $new_farm_product->seller_product_category_id = $request->seller_product_category_id;

        //location
        $location = Address::find($request->address_id);
        $new_farm_product->location = $location->district_name;
        $new_farm_product->description = $request->description;
        $new_farm_product->save();


        //image
        $new_farm_product = SellerProduct::find($new_farm_product->id);
        $new_farm_product->image = \App\Models\ImageUploader::upload($request->file('image'),'seller_products');
        $new_farm_product->save();


        return $this->sendResponse($new_farm_product->toArray(), 'Product created successfully, waiting for verification');
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
        }else{
            $success['name'] = $sellerProduct->name;
            $success['location'] = $sellerProduct->location;
            $success['price'] = $sellerProduct->price;
            $success['price_unit'] = $sellerProduct->price_unit;
            $success['status'] = $sellerProduct->status;
            $success['image'] = $sellerProduct->image;
            $success['stock_amount'] = $sellerProduct->stock_amount;
            $success['description'] = $sellerProduct->description;
            $success['category'] = $sellerProduct->seller_product_category->name;
            $success['vendor'] = $sellerProduct->user->username;
            $success['created_at'] = $sellerProduct->created_at->format('d/m/Y');
            $success['time_since'] = $sellerProduct->created_at->diffForHumans();

            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Seller Product retrieved successfully'
             ];

             return response()->json($response,200);

        }


    }


     //get vendor seller products
     public function vendor_farm_equipments(Request $request)
     {

        $vendor_farm_equipments = SellerProduct::where('user_id',auth()->user()->id)->latest()->get();


         if ($vendor_farm_equipments->count() == 0) {
             return $this->sendError('You havent posted any farm equipment');
         }
         else{


             $response = [
                 'success'=>true,
                 'data'=> [
                     'total-farm-equipments' =>$vendor_farm_equipments->count(),
                     'farm-equipments'=>$vendor_farm_equipments
                 ],
                 'message'=> 'Vendor farm equipments'
              ];

              return response()->json($response,200);
         }




     }



    public function product_search(Request $request){
        $search = $request->keyword;

        if(empty($request->keyword)){

            $response = [
                'success'=>false,
                'message'=> 'Enter a search keyword'
              ];
             return response()->json($response,200);

        }

        $total_products = SellerProduct::where('status','on-sale')->where('is_verified',1)->get();
        $products = SellerProduct::where('status','on-sale')->where('is_verified',1)->where('name', 'like', '%' . $search. '%')->orWhere('description','like', '%' . $search.'%')->get();


        if(count($products) == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>count($products)." "."results found out of"." ".count($total_products),
                    'search-results'=>$products,

                ],

                'message'=> 'search results'
              ];
             return response()->json($response,200);

        }



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


        //filter by price range
        public function price_range(Request $request){


            if(empty($request->min_price) || empty($request->max_price)){

             $response = [
                 'success'=>false,
                 'message'=> 'Price range required'
              ];

              return response()->json($response,400);

            }else{

             $seller_products = SellerProduct::select("*")->where('status','on-sale')->where('is_verified',1)->whereBetween('price', [$request->min_price, $request->max_price])->get();

             if(count($seller_products)==0){
                $response = [
                    'success'=>false,
                    'message'=> "No Farm equipemnts found between"." "."UGX ".$request->min_price ." and "."UGX ". $request->max_price
                 ];

                 return response()->json($response,404);

             }else{
                $response = [
                    'success'=>true,
                    'data'=>[
                        'total-results'=>count($seller_products),
                        'seller-products'=>$seller_products
                    ],
                    'message'=> "Farm equipemnts between "."UGX ".$request->min_price ." and "."UGX ". $request->max_price." "."retrieved successfully"
                 ];

                 return response()->json($response,200);
             }


            }




         }

         //filter products by location
         public function location_seller_products(Request $request){

             if(empty($request->district_id)){
                 $response = [
                     'success'=>false,
                     'message'=> 'Please select a district'
                  ];

                  return response()->json($response,400);

             }

             $district= District::find($request->district_id);

             if(empty($district)){
                $response = [
                    'success'=>false,
                    'message'=> 'District not found'
                 ];

                 return response()->json($response,404);

             }


             $seller_products = SellerProduct::where('status','on-sale')->where('is_verified',1)->where('location',$district->name)->get();
             $all_seller_products = SellerProduct::where('status','on-sale')->where('is_verified',1)->get();

             if(count($seller_products) == 0){

                 $response = [
                     'success'=>false,
                     'message'=> "No results found for farm equipments in"." ".$district->name
                  ];

                  return response()->json($response,404);

             }

             else{

               //  dd($seller_products);

                 $response = [
                     'success'=>true,
                     'data'=>[
                         'total-results'=>count($seller_products). " out of ".count($all_seller_products)." farm equipments in ".$district->name ,
                          'farm-equipments'=>$seller_products
                     ],
                     'message'=> 'Farm equipments retrieved successfully'
                  ];

                  return response()->json($response,200);

             }




          }


         //sorting in ascending order
         public function seller_producting_asc_sort(){

            $seller_products = SellerProduct::where('status','on-sale')->where('is_verified',1)->orderBy('name','ASC')->get();


            $response = [
                'success'=>true,
                'data'=>[
                    'total-seller-products'=>count($seller_products),
                    'seller-products'=>$seller_products
                ],
                'message'=> 'Farm equipments ordered by name in ascending order'
             ];

             return response()->json($response,200);


         }

         public function seller_producting_desc_sort(){

            $seller_products = SellerProduct::where('status','on-sale')->where('is_verified',1)->orderBy('name','DESC')->get();


            $response = [
                'success'=>true,
                'data'=>[
                    'total-seller-products'=>count($seller_products),
                    'seller-products'=>$seller_products
                ],
                'message'=> 'Farm equipments ordered by name in descending order'
             ];

             return response()->json($response,200);


         }


         public function update($id, UpdateSellerProductAPIRequest $request)


         {
        $input = $request->all();

        /** @var SellerProduct $sellerProduct */
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            return $this->sendError('Seller Product not found');
        }

        $sellerProduct = $this->sellerProductRepository->update($input, $id);

        if(!empty($request->file('image'))){
            File::delete('storage/seller_products/'.$sellerProduct->image);
            $sellerProduct->image = \App\Models\ImageUploader::upload($request->file('image'),'seller_products');
            $sellerProduct->save();
        }else{

            $sellerProduct->image= $request->image;
        }

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
