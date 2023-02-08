<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartSellerProduct;
use App\Models\SellerProduct;
use DB;

class SellerProductCartController extends Controller
{


    //get user cart items
    public function user_cart_items(){

        $user_cart = Cart::where('user_id',auth()->user()->id)->first();

        if(empty($user_cart)){

            $response = [
                'success'=>false,
                'message'=> 'Your cart is empty'
             ];

             return response()->json($response,200);

        }else{

            $products = DB::table('cart_seller_product')
                        ->join('carts', 'carts.id', '=','cart_seller_product.cart_id')
                        ->join('seller_products', 'seller_products.id', '=', 'cart_seller_product.seller_product_id')
                        ->where('cart_seller_product.cart_id', '=', $user_cart->id)
                        ->select('cart_seller_product.id','seller_products.id as seller_product_id', 'seller_products.name','cart_seller_product.quantity','cart_seller_product.total_cost','seller_products.price', 'seller_products.price_unit','seller_products.stock_amount','seller_products.image','cart_seller_product.type')->get();

            $feeds = DB::table('animal_feed_cart')
                        ->join('carts', 'carts.id', '=','animal_feed_cart.cart_id')
                        ->join('animal_feeds', 'animal_feeds.id', '=', 'animal_feed_cart.animal_feed_id')
                        ->where('animal_feed_cart.cart_id', '=', $user_cart->id)
                        ->select('animal_feed_cart.id','animal_feeds.id as animal_feed_id','animal_feeds.name','animal_feed_cart.quantity','animal_feed_cart.total_cost','animal_feeds.price', 'animal_feeds.price_unit','animal_feeds.stock_amount','animal_feeds.image','animal_feed_cart.type')->get();

            $rent = DB::table('cart_rent_vendor_service')
                        ->join('carts', 'carts.id', '=','cart_rent_vendor_service.cart_id')
                        ->join('rent_vendor_services', 'rent_vendor_services.id', '=', 'cart_rent_vendor_service.rent_vendor_service_id')
                        ->where('cart_rent_vendor_service.cart_id', '=', $user_cart->id)
                        ->select('cart_rent_vendor_service.id','rent_vendor_services.id as rent_service_id','rent_vendor_services.name','rent_vendor_services.image','cart_rent_vendor_service.quantity','cart_rent_vendor_service.charge_value','rent_vendor_services.charge','rent_vendor_services.charge_frequency','rent_vendor_services.quantity as vendor_total_items_for_hire','cart_rent_vendor_service.total_cost', 'rent_vendor_services.charge_unit','cart_rent_vendor_service.type')->get();

           //$cart_items = $products->concat($feeds);
           $all_cart_items = collect($products)->merge($feeds)->merge($rent);


           //  dd($cart_items);


            $response = [
                'success'=>true,
                'data'=>[
                    'total-cart-items'=> count($all_cart_items),
                    'total-cart-quantity'=> $all_cart_items->sum('quantity'),
                    'total-grand_amount'=> $all_cart_items->sum('total_cost'),
                     'items'=>$all_cart_items
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
