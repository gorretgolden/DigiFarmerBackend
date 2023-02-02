<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSellerProductRequest;
use App\Http\Requests\UpdateSellerProductRequest;
use App\Repositories\SellerProductRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use App\Models\SellerProduct;
use Response;
use App\Models\VendorCategory;
use App\Models\Address;
use App\Models\User;


class SellerProductController extends AppBaseController
{
    /** @var SellerProductRepository $sellerProductRepository*/
    private $sellerProductRepository;

    public function __construct(SellerProductRepository $sellerProductRepo)
    {
        $this->sellerProductRepository = $sellerProductRepo;
    }

    /**
     * Display a listing of the SellerProduct.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $sellerProducts = SellerProduct::latest()->paginate(10);

        return view('seller_products.index')
            ->with('sellerProducts', $sellerProducts);
    }

    /**
     * Show the form for creating a new SellerProduct.
     *
     * @return Response
     */
    public function create()
    {
        return view('seller_products.create');
    }

    /**
     * Store a newly created SellerProduct in storage.
     *
     * @param CreateSellerProductRequest $request
     *
     * @return Response
     */

     //fetch user addresses
    public function fetchUserAddresses(Request $request)
    {


      $data['addresses'] = Address::where("user_id", $request->user_id)->get(["district_name","address_name", "id"]);

        return response()->json($data);
    }

    public function store(CreateSellerProductRequest $request)
    {
       //existing seller products
       $existing_seller_product = SellerProduct::where('name',$request->name)->first();
       $vendor_category = VendorCategory::where('name','Farm Equipments')->first();

       if(!$existing_seller_product){
          $request->validate(SellerProduct::$rules);
          $new_seller_product = new SellerProduct();
          $new_seller_product->name = $request->name;
          $new_seller_product->description = $request->description;
          $new_seller_product->price = $request->price;
          $new_seller_product->image = $request->image;
          $new_farm_product->price_unit = "UGX";
          $new_farm_product->status = "on-sale";

           //set user as a vendor
          $user = User::find($request->user_id);
          if(!$user->is_vendor ==1){
            $user->is_vendor =1;
            $user->save();
          }

          $new_seller_product->user_id = $request->user_id;
          $new_seller_product->seller_product_category_id = $request->seller_product_category_id;
          $new_seller_product->vendor_category_id = $vendor_category->id;
           //location
          $location = Address::find($request->address_id);
          $new_seller_product->address_id = $location->district_name;
          $new_seller_product->save();

          $new_seller_product = SellerProduct::find($new_seller_product->id);

          $new_seller_product->image = \App\Models\ImageUploader::upload($request->file('image'),'seller_products');
          $new_seller_product->save();

          Flash::success('Product saved successfully.');
          return redirect(route('sellerProducts.index'));
       }
       else{
          Flash::error('Product name already exists');
          return redirect(route('sellerProducts.index'));
       }

      return redirect(route('sellerProducts.index'));
    }

    /**
     * Display the specified SellerProduct.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            Flash::error('Seller Product not found');

            return redirect(route('sellerProducts.index'));
        }

        return view('seller_products.show')->with('sellerProduct', $sellerProduct);
    }

    /**
     * Show the form for editing the specified SellerProduct.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            Flash::error('Seller Product not found');

            return redirect(route('sellerProducts.index'));
        }

        return view('seller_products.edit')->with('sellerProduct', $sellerProduct);
    }

    /**
     * Update the specified SellerProduct in storage.
     *
     * @param int $id
     * @param UpdateSellerProductRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSellerProductRequest $request)
    {
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            Flash::error('Seller Product not found');

            return redirect(route('sellerProducts.index'));
        }

        $sellerProduct = $this->sellerProductRepository->update($request->all(), $id);

        Flash::success('Seller Product updated successfully.');

        return redirect(route('sellerProducts.index'));
    }

    /**
     * Remove the specified SellerProduct from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            Flash::error('Seller Product not found');

            return redirect(route('sellerProducts.index'));
        }

        $this->sellerProductRepository->delete($id);

        Flash::success('Seller Product deleted successfully.');

        return redirect(route('sellerProducts.index'));
    }
}
