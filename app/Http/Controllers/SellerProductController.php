<?php



namespace App\Http\Controllers;


use App\DataTables\SellerProductDataTable;
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






}
