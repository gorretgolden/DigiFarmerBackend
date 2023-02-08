<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartRentVendorService;
use App\Models\RentVendorService;
use DB;

class CartRentVendorServiceController extends Controller
{



    public function increase_quantity(Request $request,$id){

        $product = CartRentVendorService::find($id);

        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,400);

        }
        //check for stock amount
        $rent_product = RentVendorService::find($product->rent_product_id);

        if($product->quantity > ($rent_product->stock_amount - 1 )  ){


            $response = [
                'success'=>false,
                'message'=> $rent_product->stock_amount." " ."items in stock"
             ];
             return response()->json($response,404);

        }else{


            if( (CartRentVendorService::where('id',$id)->update(['quantity'=> DB::raw('quantity+1'),'total_cost'=> DB::raw("quantity * '$rent_product->price'")])) == 1){
                $response = [
                    'success'=>true,
                    'message'=> 'Product quantity has been increased successfully'
                 ];
                 return response()->json($response,200);

            }else{
                $response = [
                    'success'=>false,
                    'message'=> 'Something went wrong'
                 ];
                 return response()->json($response,400);

            }




        }






    }


    public function decrease_quantity(Request $request,$id){
        $product = CartRentVendorService::find($id);


        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,400);
         }

        if( (CartRentVendorService::where('id',$id)->update(['quantity'=> DB::raw('quantity-1'),'total_cost'=> DB::raw("quantity * '$rent_product->price'")])) == 1){
            $response = [
                'success'=>true,
                'message'=> 'Product quantity has been reduced successfully'
             ];
             return response()->json($response,200);

        }else{
            $response = [
                'success'=>false,
                'message'=> 'Something went wrong'
             ];
             return response()->json($response,400);

        }


    }


    //delete item in cart
    public function delete_cart_item(Request $request,$id){

        $product = CartRentVendorService::find($id);

        if (empty($product)) {
            return $this->sendError('Cart product not found');
        }

        $product->delete();
        $response = [
            'success'=>true,
            'message'=> 'Product was removed from the cart'
         ];
         return response()->json($response,200);


    }
}
