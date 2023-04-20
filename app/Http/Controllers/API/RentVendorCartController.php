<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use DB;
use App\Models\CartItem;
use App\Models\RentVendorService;

class RentVendorCartController extends Controller
{

     //add item to cart
     public function add_product_to_cart(Request $request,$id){

        // $request->validate(
        //     [
        //         'days'=>'required|integer|min:1|max:30'
        //     ]
        // );


        $rent_vendor_service = RentVendorService::find($id);
        if (empty($rent_vendor_service)) {

            $response = [
                'success'=>false,
                'message'=> 'Rent Vendor Service not found'
              ];

              return response()->json($response,404);

        }


        //check user cart
        $existing_user_cart = Cart::where('user_id',auth()->user()->id)->first();


        if($existing_user_cart){

            //check if product exists in cart
            if(CartItem::where('cart_id',$existing_user_cart->id)->where('rent_vendor_service_id',$id)->first()){

                $response = [
                    'success'=>false,
                    'message'=> 'Product already exits in the cart'
                 ];


                 return response()->json($response,409);

            }else{
                 //save product to cart


                $new_cart_product = new CartItem();
                $new_cart_product->cart_id = $existing_user_cart->id;
                $new_cart_product->rent_vendor_service_id = $id;
                $new_cart_product->type = "rent";


                //charge frequency
                if($rent_vendor_service->charge_frequency == "per piece"){
                    $new_cart_product->quantity = 1;
                    $new_cart_product->total_cost = $rent_vendor_service->charge;
                }else{

                    //days and hours
                    $new_cart_product->quantity = 1;
                    $new_cart_product->charge_value = 1;
                    $new_cart_product->total_cost = $rent_vendor_service->charge;
                }

                $new_cart_product->save();

                $success['id'] = $new_cart_product->id;
                $success['cart_id'] = $new_cart_product->cart_id;
                $success['rent_vendor_service_id'] = $new_cart_product->rent_vendor_service_id;
                $success['type'] = $new_cart_product->type;
                $success['quantity'] = $new_cart_product->quantity;
                $success['charge_value'] = $new_cart_product->charge_value;
                $success['total_cost'] = $new_cart_product->total_cost;

               $response = [
                 'success'=>true,
                 'data'=> $success,
                 'message'=> 'Product added to cart successfully'
               ];

               return response()->json($response,201);

            }



        }else{

            //create a new cart instance for a user
            $new_cart = new Cart();
            $new_cart->user_id = auth()->user()->id;
            $new_cart->save();


            $new_cart_product = new CartItem();
            $new_cart_product->cart_id = $new_cart->id;
            $new_cart_product->rent_vendor_service_id = $id;
            $new_cart_product->type = 'rent';
            $new_cart_product->save();

             //charge frequency
             if($rent_vendor_service->charge_frequency == "per piece"){
                $new_cart_product->quantity = 1;
                $new_cart_product->total_cost = $rent_vendor_service->charge;
            }else{

                //days and hours
                $new_cart_product->quantity = 1;
                $new_cart_product->charge_value = 1;
                $new_cart_product->total_cost = $rent_vendor_service->charge;
            }

            $new_cart_product->save();

            $response = [
                'success'=>true,
                'data'=> $new_cart_product,
                'message'=> 'Product added to cart successfully'
                ];

            return response()->json($response,201);



        }




    }


    public function increase_quantity(Request $request,$id){

        $product = CartItem::find($id);



        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,404);

        }
        //check for stock amount
        $rent_vendor_service = RentVendorService::find($product->rent_vendor_service_id);

        if($product->quantity > ($rent_vendor_service->quantity - 1 )  ){


            $response = [
                'success'=>false,
                'message'=> $rent_vendor_service->quantity." " ."items available for rent"
             ];
             return response()->json($response,400);

        }elseif($rent_vendor_service->charge_frequency == "per piece"){

         CartItem::where('id',$id)->update(['quantity'=> DB::raw('quantity+1'),'total_cost'=> DB::raw("quantity * '$rent_vendor_service->charge'")]);
            $response = [
                'success'=>true,
                'message'=> 'Product quantity has been increased successfully'
            ];
            return response()->json($response,200);




        }else{
            CartItem::where('id',$id)->update(['quantity'=> DB::raw('quantity+1')]);
            $response = [
                'success'=>true,
                'message'=> 'Product quantity has been increased successfully'
            ];
            return response()->json($response,200);

        }






    }


    public function decrease_quantity(Request $request,$id){
        $product = CartItem::find($id);
        $rent_vendor_service = RentVendorService::find($product->rent_vendor_service_id);

        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,400);
         }
         elseif($rent_vendor_service->charge_frequency == "per piece"){
            CartItem::where('id',$id)->update(['quantity'=> DB::raw('quantity-1'),'total_cost'=> DB::raw("quantity * '$rent_vendor_service->charge'")]);
            $response = [
                'success'=>true,
                'message'=> 'Product quantity has been reduced successfully'
             ];
             return response()->json($response,200);
         }else{

            CartItem::where('id',$id)->update(['quantity'=> DB::raw('quantity-1')]);
            $response = [
                'success'=>true,
                'message'=> 'Product quantity has been reduced successfully'
             ];
             return response()->json($response,200);

         }




    }



    public function increase_days(Request $request,$id){

        $product = CartItem::find($id);



        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,404);

        }
        //check for stock amount
        $rent_vendor_service = RentVendorService::find($product->rent_vendor_service_id);

       if($rent_vendor_service->charge_frequency == "per piece"){


            $response = [
                'success'=>true,
                'message'=> 'Rent charge is per piece'
            ];
            return response()->json($response,200);




        }else{
            CartItem::where('id',$id)->update(['charge_value'=> DB::raw('charge_value+1'),'total_cost'=> DB::raw("charge_value * '$rent_vendor_service->charge'")]);
            $response = [
                'success'=>true,
                'message'=> 'Product charge period has been increased successfully'
            ];
            return response()->json($response,200);

        }






    }



    public function reduce_days(Request $request,$id){

        $product = CartItem::find($id);



        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,404);

        }
        //check for stock amount
        $rent_vendor_service = RentVendorService::find($product->rent_vendor_service_id);

       if($rent_vendor_service->charge_frequency == "per piece"){


            $response = [
                'success'=>true,
                'message'=> 'Rent charge is per piece'
            ];
            return response()->json($response,200);




        }else{
            CartItem::where('id',$id)->update(['charge_value'=> DB::raw('charge_value-1'),'total_cost'=> DB::raw("charge_value * '$rent_vendor_service->charge'")]);
            $response = [
                'success'=>true,
                'message'=> 'Product charge period has been reduced successfully'
            ];
            return response()->json($response,200);

        }






    }

    //delete item in cart
    public function delete_cart_item(Request $request,$id){

        $product = CartItem::find($id);

        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Product not found'
             ];
             return response()->json($response,404);

        }

        $product->delete();
        $response = [
            'success'=>true,
            'message'=> 'Product was removed from the cart'
         ];
         return response()->json($response,200);


    }
}
