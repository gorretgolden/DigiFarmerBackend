<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    public $table = 'cart_items';


    public $fillable = [
        'cart_id',
        'rent_vendor_service_id',
        'seller_product_id',
        'animal_feed_id',
        'quantity'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

        'cart_id'=>'integer',
        'rent_vendor_service_id'=>'integer',
        'seller_product_id'=>'integer',
        'animal_feed_id' =>'integer',
        'quantity'=>'integer',
        'type'=>'string',
        'charge_value'=>'integer',
        'grand_total'=>'integer',
        'total_cost'=>'integer'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'cart_id' => 'nullable|integer',
        'rent_vendor_service_id' => 'nullable|integer',
        'seller_product_id' => 'nullable|integer',
        'animal_feed_id' =>'integer',
        'quantity'=>'integer|nullable',
        'type'=>'string|required',
        'charge_value'=>'integer|nullable',
        'grand_total'=>'integer|nullable',
        'total_cost'=>'integer|nullable'

    ];

    public function user_cart_items(){

        $user_cart = Cart::where('user_id',auth()->user()->id)->first();

        if(empty($user_cart)){

            $response = [
                'success'=>false,
                'message'=> 'Your cart is empty'
             ];

             return response()->json($response,200);

        }else{

            $products = DB::table('cart_items')
                        ->join('carts', 'carts.id', '=','cart_items.cart_id')
                        ->leftJoin('seller_products', 'seller_products.id', '=', 'cart_items.seller_product_id')
                        ->leftJoin('animal_feeds', 'animal_feeds.id', '=', 'cart_items.animal_feed_id')
                        ->leftJoin('rent_vendor_services', 'rent_vendor_services.id', '=', 'cart_items.rent_vendor_service_id')
                        ->where('cart_items.user_id', '=', $user_cart->user_id)
                        ->select('seller_products.id as seller_product_id', 'seller_products.name')->get();

                        dd($products);

                        // 'cart_seller_product.quantity','cart_seller_product.total_cost','seller_products.price', 'seller_products.price_unit','seller_products.stock_amount','seller_products.image','cart_seller_product.type'
            // $feeds = DB::table('animal_feed_cart')
            //             ->join('carts', 'carts.id', '=','animal_feed_cart.cart_id')
            //             ->join('animal_feeds', 'animal_feeds.id', '=', 'animal_feed_cart.animal_feed_id')
            //             ->where('animal_feed_cart.cart_id', '=', $user_cart->id)
            //             ->select('animal_feed_cart.id','animal_feeds.id as animal_feed_id','animal_feeds.name','animal_feed_cart.quantity','animal_feed_cart.total_cost','animal_feeds.price', 'animal_feeds.price_unit','animal_feeds.stock_amount','animal_feeds.image','animal_feed_cart.type')->get();

            // $rent = DB::table('cart_rent_vendor_service')
            //             ->join('carts', 'carts.id', '=','cart_rent_vendor_service.cart_id')
            //             ->join('rent_vendor_services', 'rent_vendor_services.id', '=', 'cart_rent_vendor_service.rent_vendor_service_id')
            //             ->where('cart_rent_vendor_service.cart_id', '=', $user_cart->id)
            //             ->select('cart_rent_vendor_service.id','rent_vendor_services.id as rent_service_id','rent_vendor_services.name','rent_vendor_services.image','cart_rent_vendor_service.quantity','cart_rent_vendor_service.charge_value','rent_vendor_services.charge','rent_vendor_services.charge_frequency','rent_vendor_services.quantity as vendor_total_items_for_hire','cart_rent_vendor_service.total_cost', 'rent_vendor_services.charge_unit','cart_rent_vendor_service.type')->get();

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

}
