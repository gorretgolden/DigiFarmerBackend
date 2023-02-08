<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnimalFeedCart;
use App\Models\Cart;
use App\Models\AnimalFeed;
use DB;

class AnimalFeedCartController extends Controller
{


     //add item to cart
     public function add_product_to_cart(Request $request,$id){

        //check user cart
        $existing_user_cart = Cart::where('user_id',auth()->user()->id)->first();


        if($existing_user_cart){

            //check if product exists in cart
            if(AnimalFeedCart::where('cart_id',$existing_user_cart->id)->where('animal_feed_id',$id)->first()){

                $response = [
                    'success'=>false,
                    'message'=> 'Product already exits in the cart'
                 ];


                 return response()->json($response,409);

            }else{
                 //save product to cart
                $animal_feed = AnimalFeed::find($id);
                $new_cart_product = new AnimalFeedCart();
                $new_cart_product->cart_id = $existing_user_cart->id;
                $new_cart_product->animal_feed_id = $id;
                $new_cart_product->type = 'animal-feeds';
                $new_cart_product->quantity = 1;
                $new_cart_product->total_cost = $animal_feed->price;
                $new_cart_product->save();

               $response = [
                 'success'=>true,
                 'data'=> $new_cart_product,
                 'message'=> 'Product added to cart successfully'
               ];

               return response()->json($response,201);

            }



        }else{

            //create a new cart instance for a user
            $new_cart = new Cart();
            $new_cart->user_id = auth()->user()->id;
            $new_cart->save();


            $new_cart_product = new AnimalFeedCart();
            $new_cart_product->cart_id = $new_cart->id;
            $new_cart_product->animal_feed_id = $id;
            $new_cart_product->type = 'animal-feeds';
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

        $product = AnimalFeedCart::find($id);

        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,400);

        }
        //check for stock amount
        $animal_feed = AnimalFeed::find($product->animal_feed_id);

        if($product->quantity > ($animal_feed->stock_amount - 1 )  ){


            $response = [
                'success'=>false,
                'message'=> $animal_feed->stock_amount." " ."items in stock"
             ];
             return response()->json($response,404);

        }else{


            if( (AnimalFeedCart::where('id',$id)->update(['quantity'=> DB::raw('quantity+1'),'total_cost'=> DB::raw("quantity * '$animal_feed->price'")])) == 1){
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
        $product = AnimalFeedCart::find($id);


        if (empty($product)) {
            $response = [
                'success'=>false,
                'message'=> 'Cart product not found'
             ];
             return response()->json($response,400);
         }

        if( (AnimalFeedCart::where('id',$id)->update(['quantity'=> DB::raw('quantity-1'),'total_cost'=> DB::raw("quantity * '$animal_feed->price'")])) == 1){
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

        $product = AnimalFeedCart::find($id);

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
