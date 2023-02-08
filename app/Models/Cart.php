<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;




    public $table = 'carts';


    public $fillable = [
        'user_id',

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

        'user_id'=>'integer'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable|integer'

    ];

    //belongs to a user
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    //belongs to many seller products
    public function seller_products()
    {
        return $this->belongsToMany(\App\Models\SellerProduct::class, 'cart_seller_product', 'cart_id', 'seller_product_id');
    }

    //belongs to many animals feeds
    public function animal_feeds()
    {
        return $this->belongsToMany(\App\Models\AnimalFeed::class, 'animal_feed_cart', 'cart_id', 'animal_feed_id');
    }




}
