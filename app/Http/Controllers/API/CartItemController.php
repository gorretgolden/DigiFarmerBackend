<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartSellerProduct;
use App\Models\SellerProduct;
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
                        ->leftJoin('animal_feeds', 'animal_feeds.id', '=', 'cart_items.animal_feed_id')
                        ->leftJoin('seller_products', 'seller_products.id', '=', 'cart_items.seller_product_id')
                        ->leftJoin('rent_vendor_services', 'rent_vendor_services.id', '=', 'cart_items.rent_vendor_service_id')
                        ->where('carts.user_id', '=', $user_cart->user_id)
                        ->select('carts.user_id as user_id',DB::raw("coalesce(cart_items.seller_product_id, cart_items.animal_feed_id,cart_items.rent_vendor_service_id) as product_id"),'cart_items.quantity','cart_items.type','cart_items.charge_value','cart_items.total_cost')
                        ->get();




          // dd($products);


            $response = [
                'success'=>true,
                'data'=>[
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


        if($existing_user_cart){

            //check if product exists in cart
            if(CartSellerProduct::where('cart_id',$existing_user_cart->id)->where('seller_product_id',$id)->first()){

                $response = [
                    'success'=>false,
                    'message'=> 'Product already exits in the cart'
                 ];


                 return response()->json($response,409);

            }else{
                 //save product to cart

                $seller_product = SellerProduct::find($id);
                if (empty($seller_product)) {
                    $response = [
                        'success'=>false,
                        'message'=> 'Product not found'
                      ];

                      return response()->json($response,404);


                }

                $new_cart_product = new CartSellerProduct();
                $new_cart_product->cart_id = $existing_user_cart->id;
                $new_cart_product->seller_product_id = $id;
                $new_cart_product->type = 'farm-equipments';
                $new_cart_product->quantity = 1;
                $new_cart_product->total_cost = $seller_product->price;
                $new_cart_product->save();

                $success['id'] = $new_cart_product->id;
                $success['cart_id'] = $new_cart_product->cart_id;
                $success['seller_product_id'] = $new_cart_product->seller_product_id;
                $success['type'] = $new_cart_product->type;
                $success['quantity'] = $new_cart_product->quantity;
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


            $new_cart_product = new CartSellerProduct();
            $new_cart_product->cart_id = $new_cart->id;
            $new_cart_product->seller_product_id = $id;
            $new_cart_product->type = 'farm-equipments';
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
        $product = CartSellerProduct::find($id);

        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,400);

        }
        //check for stock amount
        $seller_product = SellerProduct::find($product->seller_product_id);

        if($product->quantity > ($seller_product->stock_amount - 1 )  ){


            $response = [
                'success'=>false,
                'message'=> $seller_product->stock_amount." " ."items in stock"
             ];
             return response()->json($response,404);

        }else{


            if( (CartSellerProduct::where('id',$id)->update(['quantity'=> DB::raw('quantity+1'),'total_cost'=> DB::raw("quantity * '$seller_product->price'")])) == 1){
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
        $product = CartSellerProduct::find($id);
        $seller_product = SellerProduct::find($product->seller_product_id);

        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,400);
         }

        if( (CartSellerProduct::where('id',$id)->update(['quantity'=> DB::raw('quantity-1'),'total_cost'=> DB::raw("quantity * '$seller_product->price'")])) == 1){
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

        $product = CartSellerProduct::find($id);

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


}
