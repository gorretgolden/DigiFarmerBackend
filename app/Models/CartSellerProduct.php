<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartSellerProduct extends Model
{
    use HasFactory;
    public $table = 'cart_seller_product';


    public $fillable = [
        'cart_id',
        'seller_product_id'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

        'cart_id'=>'integer',
        'seller_product_id'=>'integer'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'cart_id' => 'required|integer',
        'seller_product_id' => 'required|integer'

    ];

}
