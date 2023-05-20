<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\VendorService;
use DB;

class CartItemController extends Controller
{

    //get user cart items
    public function user_cart_items(){

        $user_cart = Cart::where('user_id',auth()->user()->id)->first();
        //dd($user_cart->user_id);

        if(empty($user_cart)){

            $response = [
                'success'=>false,
                'message'=> 'Your cart is empty'
             ];

             return response()->json($response,200);

        }else{

            $all_user_cart_items= DB::table('carts')
                        ->join('cart_items', 'carts.id', '=','cart_items.cart_id')
                        ->join('vendor_services', 'vendor_services.id', '=', 'cart_items.vendor_service_id')
                        ->where('carts.user_id', '=', $user_cart->user_id)
                        ->select('cart_items.id as cart_item_id','cart_items.quantity','carts.user_id','cart_items.type','cart_items.charge_value','vendor_services.id as vendor_service_id',DB::raw("CONCAT('https://digifarmer.agrosahas.co/farmerapp/public/storage/vendor_services/', vendor_services.image) AS image"),'vendor_services.name','vendor_services.price_unit','vendor_services.price','vendor_services.charge','cart_items.total_cost')
                        ->get();




          // dd($products);

            $response = [
                'success'=>true,
                'data'=>[
                    'cart-id'=> $user_cart->id,
                    'user_id'=>$user_cart->user_id,
                    'total-cart-items'=> count($all_user_cart_items),
                    'total-cart-quantity'=> $all_user_cart_items->sum('quantity'),
                    'total-grand_amount'=> $all_user_cart_items->sum('total_cost'),
                    'items'=>$all_user_cart_items
                ],
                'message'=> 'User cart items retrieved '
             ];


             return response()->json($response,200);
        }





    }

    //add item to cart
    public function add_product_to_cart(Request $request,$id){



        //check user cart
        $existing_user_cart = Cart::where('user_id',auth()->user()->id)->first();
        $vendor_service = VendorService::find($id);


        if (empty($vendor_service)) {
            $response = [
                'success'=>false,
                'message'=> 'Product not found'
              ];

              return response()->json($response,404);


        }

        $category = $vendor_service->sub_category->category->name;


        if($existing_user_cart){


            //check if product exists in cart
            if(CartItem::where('cart_id',$existing_user_cart->id)->where('vendor_service_id',$id)->first()){

                $response = [
                    'success'=>false,
                    'message'=> 'Product already exits in the cart'
                 ];


                 return response()->json($response,409);

            }else{
                 //save product to cart




                $new_cart_product = new CartItem();
                $new_cart_product->cart_id = $existing_user_cart->id;
                $new_cart_product->vendor_service_id = $id;
                $new_cart_product->quantity = 1;
                $new_cart_product->user_id = $request->user()->id;



                if($category == 'Rent'){

                    $new_cart_product->total_cost = $vendor_service->charge;
                    $new_cart_product->type = 'rent';
                    $new_cart_product->save();

                }elseif($category == 'Animal Feeds'){

                    $new_cart_product->total_cost = $vendor_service->price;
                    $new_cart_product->type = 'animal-feeds';
                    $new_cart_product->save();
                }else{
                    $new_cart_product->total_cost = $vendor_service->price;
                    $new_cart_product->type = 'farm-equipments';
                    $new_cart_product->save();

                }




                $success['id'] = $new_cart_product->id;
                $success['cart_id'] = $new_cart_product->cart_id;
                $success['vendor_service_id'] = $new_cart_product->vendor_service_id;
                $success['quantity'] = $new_cart_product->quantity;
                $success['type'] = $new_cart_product->type;
                $success['total_cost'] = $new_cart_product->total_cost;
                $success['user_id'] = $new_cart_product->user_id;



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
            $new_cart_product->vendor_service_id = $id;
            $new_cart_product->user_id = $request->user()->id;

            if($category == 'Rent'){

                $new_cart_product->total_cost = $vendor_service->charge;
                $new_cart_product->type = 'rent';
                $new_cart_product->save();

            }elseif($category == 'Animal Feeds'){

                $new_cart_product->total_cost = $vendor_service->price;
                $new_cart_product->type = 'animal-feeds';
                $new_cart_product->save();
            }else{
                $new_cart_product->total_cost = $vendor_service->price;
                $new_cart_product->type = 'farm-equipments';
                $new_cart_product->save();

            }


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
        $price = 1;

        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,400);

        }

        //check for vendor category
        $vendor_service = VendorService::find($product->vendor_service_id);
       // dd($vendor_service);

        if($vendor_service->sub_category->category->name == 'Rent'  && !empty($vendor_service->charge)){

            $price = $vendor_service->charge;
           // dd('charge',$price);

        }else{
            $price = $vendor_service->price;
           // dd('price',$price);

        }

        //check for stock amount


        if($product->quantity > ($vendor_service->stock_amount - 1 )  ){


            $response = [
                'success'=>false,
                'message'=> $vendor_service->name." has only ".$vendor_service->stock_amount." items in stock"
             ];
             return response()->json($response,400);

        }else{


            if( (CartItem::where('id',$id)->update(['quantity'=> DB::raw('quantity+1'),'total_cost'=> DB::raw("quantity * '$price'")])) == 1){
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
        $product = CartItem::find($id);
        $vendor_service = VendorService::find($product->vendor_service_id);
        $price = 1;

        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,400);
         }


         //price
         if($vendor_service->sub_category->category->name == 'Rent'  && !empty($vendor_service->charge)){

            $price = $vendor_service->charge;
           // dd('charge',$price);

        }else{
            $price = $vendor_service->price;
           // dd('price',$price);

        }
        if( (CartItem::where('id',$id)->update(['quantity'=> DB::raw('quantity-1'),'total_cost'=> DB::raw("quantity * '$price'")])) == 1){
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

        $product = CartItem::find($id);

        if (empty($product)) {
            $response = [
                'success'=>true,
                'message'=> 'Product not found'
             ];
             return response()->json($response,200);
        }

        $product->delete();
        $response = [
            'success'=>true,
            'message'=> 'Product was removed from the cart'
         ];
         return response()->json($response,200);


    }


    //increase hours or days for a rent cart item
    public function increase_charge_value(Request $request,$id){

        $product = CartItem::find($id);
        $vendor_service = VendorService::find($product->vendor_service_id);



        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,404);

        }

        //only rent items for cahrge values
        if(!($product->type == 'rent')){
            $response = [
                'success'=>false,
                'message'=> 'Charge value is only increased for rent items on hire'
             ];
             return response()->json($response,400);

        }

           //check for stock amount


        if($vendor_service->charge_frequency == "per piece"){


             $response = [
                 'success'=>true,
                 'message'=> 'Rent charge is per piece'
             ];
             return response()->json($response,200);




         }else{
             CartItem::where('id',$id)->update(['charge_value'=> DB::raw('charge_value+1'),'total_cost'=> DB::raw("charge_value * '$vendor_service->charge'")]);
             $response = [
                 'success'=>true,
                 'message'=> 'Product charge period has been increased successfully'
             ];
             return response()->json($response,200);

           }









    }



    public function reduce_charge_value(Request $request,$id){

        $product = CartItem::find($id);



        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,404);

        }



            //only rent items for cahrge values
        if(!($product->type == 'rent')){
            $response = [
                    'success'=>false,
                    'message'=> 'Charge value is only increased for rent items on hire'
            ];
             return response()->json($response,400);

        }


        //check for stock amount
        $vendor_service = VendorService::find($product->vendor_service_id);

       if($vendor_service->charge_frequency == "per piece"){


            $response = [
                'success'=>true,
                'message'=> 'Rent charge is per piece'
            ];
            return response()->json($response,200);




        }else{
            CartItem::where('id',$id)->update(['charge_value'=> DB::raw('charge_value-1'),'total_cost'=> DB::raw("charge_value * '$vendor_service->charge'")]);
            $response = [
                'success'=>true,
                'message'=> 'Product charge period has been reduced successfully'
            ];
            return response()->json($response,200);

        }






    }


}
