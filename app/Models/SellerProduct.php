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
    public $dir = 'storage/seller_products/';





    public $fillable = [
        'name',
        'description',
        'price',
        'seller_product_category_id',
        'image',
        'user_id',
        'address_id'

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
        'user_id'=> 'integer',
        'address_id'=>'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|unique:seller_products',
        'description' => 'required|string|min:10',
        'price' => 'required|integer',
        'seller_product_category_id' => 'required|integer',
        'image' => 'required',
        'user_id'=> 'required',
        'address_id'=>'required|integer'
    ];

     //a seller product belongs to a seller product category
     public function seller_product_category()
     {
        return $this->belongsTo(\App\Models\SellerProductCategory::class);
     }


     //a seller product belongs to a user

     public function user()
     {
         return $this->belongsTo(\App\Models\User::class,'user_id');
     }

     //belongs to an address
     public function address()
     {
        return $this->belongsTo(\App\Models\Address::class,'address_id');
     }

     //belongs to a vendor category
     public function vendor_category()
    {
        return $this->hasMany(\App\Models\VendorCategory::class,'vendor_category_id');
    }

    public function getImageAttribute($value)
    {


     return $this->dir.$value;
    }
}
