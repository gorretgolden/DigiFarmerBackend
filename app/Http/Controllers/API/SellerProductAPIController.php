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
        $sellerProducts = $this->sellerProductRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

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
            'address_id'=>'required|integer'
        ];
        $request->validate($rules);

        $vendor_category = VendorCategory::where('name','Farm Equipments')->first();

        $new_farm_product = new SellerProduct();
        $new_farm_product->name = $request->name;
        $new_farm_product->price = $request->price;
        $new_farm_product->price_unit = "UGX";
        $new_farm_product->status = "on-sale";
        $new_farm_product->image = $request->image;


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


        return $this->sendResponse($new_farm_product->toArray(), 'Seller Product saved successfully');
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
            $success['price'] = $sellerProduct->price_unit." ".$sellerProduct ->price;
            $success['status'] = $sellerProduct->status;
            $success['image'] = $sellerProduct->image;
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

    /**
     * Update the specified SellerProduct in storage.
     * PUT/PATCH /sellerProducts/{id}
     *
     * @param int $id
     * @param UpdateSellerProductAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSellerProductAPIRequest $request)
    {
        $input = $request->all();

        /** @var SellerProduct $sellerProduct */
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            return $this->sendError('Seller Product not found');
        }

        $sellerProduct = $this->sellerProductRepository->update($input, $id);

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
