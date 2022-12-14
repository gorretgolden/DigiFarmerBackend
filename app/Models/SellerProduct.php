<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SellerProduct
 * @package App\Models
 * @version November 4, 2022, 12:46 pm UTC
 *
 * @property string $name
 * @property string $description
 * @property integer $price
 * @property integer $seller_product_category_id
 * @property string $image
 */
class SellerProduct extends Model
{

    use HasFactory;

    public $table = 'seller_products';





    public $fillable = [
        'name',
        'description',
        'price',
        'seller_product_category_id',
        'image',
         'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'price' => 'integer',
        'seller_product_category_id' => 'integer',
        'image' => 'string',
        'user_id'=> 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|unique:seller_products',
        'description' => 'required|string',
        'price' => 'required|integer',
        'seller_product_category_id' => 'required|integer',
        'image' => 'required',
        'user_id'=> 'required'
    ];

     //a seller product belongs to a seller product category
     public function seller_product_category()
     {
        return $this->belongsTo(\App\Models\SellerProductCategory::class);
     }


}
