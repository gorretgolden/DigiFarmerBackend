<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FarmerBuySellerProduct
 * @package App\Models
 * @version November 18, 2022, 1:18 am UTC
 *
 * @property boolean $is_product_bought
 * @property integer $seller_product_id
 * @property integer $user_id
 */
class FarmerBuySellerProduct extends Model
{


    use HasFactory;

    public $table = 'farmer_buy_seller_products';





    public $fillable = [
        'is_product_bought',
        'seller_product_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_product_bought' => 'boolean',
        'seller_product_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'is_product_bought' => 'nullable',
        'seller_product_id' => 'required|integer',
        'user_id' => 'required|integer'
    ];


}
