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
use Illuminate\Support\Facades\File;

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
     * @param SellerProductDataTable $sellerProductDataTable
     *
     * @return Response
     */
    public function index(SellerProductDataTable $sellerProductDataTable)
    {
        return $sellerProductDataTable->render('seller_products.index');
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


       $data['addresses'] = Address::where("user_id", $request->user_id)->get(["district_name", "id"]);


         return response()->json($data);
     }


     public function store(CreateSellerProductRequest $request)
     {


        //existing seller products
        $existing_seller_product = SellerProduct::where('name',$request->name)->first();
        $vendor_category = VendorCategory::where('name','Farm Equipments')->first();


        if(!$existing_seller_product){


           $new_seller_product = new SellerProduct();
           $new_seller_product->name = $request->name;
           $new_seller_product->description = $request->description;
           $new_seller_product->price = $request->price;
           $new_seller_product->image = $request->image;
           $new_seller_product->stock_amount = $request->stock_amount;
           $new_seller_product->price_unit = "UGX";
           $new_seller_product->status = "on-sale";
           $new_seller_product->is_verified = $request->is_verified;
           $new_seller_product->stock_amount = $request->stock_amount;


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
           $new_seller_product->location = $location->district_name;
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
     public function update($id, Request $request)
     {
         //dd($request->all());
         $rules = [
             'name' => 'required|string',
             'description' => 'required|string|min:10',
             'price' => 'required|integer',
             'seller_product_category_id' => 'required|integer',
             'image' => 'nullable',
             'user_id'=> 'required|integer',
             'address_id'=>'nullable|integer',
             'stock_amount'=>'required|integer'
         ];
         $request->validate($rules);
         $sellerProduct = $this->sellerProductRepository->find($id);


         if (empty($sellerProduct)) {
             Flash::error('Seller Product not found');


             return redirect(route('sellerProducts.index'));
         }
         $location = Address::find($request->address_id);


         $sellerProduct->name = $request->name;
         $sellerProduct->description = $request->description;
         $sellerProduct->price = $request->price;
         $sellerProduct->is_verified = $request->is_verified;
         $sellerProduct->stock_amount = $request->stock_amount;
         $sellerProduct->user_id = $request->user_id;
         $sellerProduct->seller_product_category_id = $request->seller_product_category_id;
         $sellerProduct->save();


          //location


         if(!empty($request->address_id)){
             $location = Address::find($request->address_id);
             $sellerProduct->location = $location->district_name;
             $sellerProduct->save();


         }




         //$sellerProduct = $this->sellerProductRepository->update($request->all(), $id);


         if(!empty($request->file('image'))){
             File::delete('storage/seller_products/'.$sellerProduct->image);
             $sellerProduct->image = \App\Models\ImageUploader::upload($request->file('image'),'seller_products');
             $sellerProduct->save();
         }


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
