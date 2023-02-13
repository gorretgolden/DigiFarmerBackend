<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnimalFeed
 * @package App\Models
 * @version February 8, 2023, 8:44 pm CET
 *
 * @property string $name
 * @property integer $price
 * @property string $price_unit
 * @property integer $weight
 * @property string $weight_unit
 * @property intger $stock_amount
 * @property string $location
 * @property string $image
 * @property string $description
 * @property string $status
 * @property boolean $is_verified
 * @property integer $user_id
 * @property integer $animal_feed_category_id
 * @property integer $vendor_category_id
 */
class AnimalFeed extends Model
{

    use HasFactory;

    public $table = 'animal_feeds';
    public $dir = 'storage/animal_feeds/';




    public $fillable = [
        'name',
        'price',
        'price_unit',
        'weight',
        'weight_unit',
        'stock_amount',
        'location',
        'image',
        'description',
        'status',
        'is_verified',
        'user_id',
        'animal_feed_category_id',
        'vendor_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'price' => 'integer',
        'price_unit' => 'string',
        'weight' => 'integer',
        'weight_unit' => 'string',
        'location' => 'string',
        'image' => 'string',
        'description' => 'string',
        'status' => 'string',
        'is_verified' => 'boolean',
        'user_id' => 'integer',
        'animal_feed_category_id' => 'integer',
        'vendor_category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|min:10|max:100',
        'price' => 'required|integer',
        'price_unit' => 'nullable',
        'weight' => 'required|integer',
        'weight_unit' => 'required|string',
        'stock_amount' => 'required|integer',
        'address_id' => 'required|integer',
        'image' => 'required',
        'description' => 'required|string|min:10',
        'status' => 'nullable',
        'is_verified' => 'nullable',
        'user_id' => 'required|integer',
        'animal_feed_category_id' => 'required|integer',
        'vendor_category_id' => 'nullable'
    ];


    //an animal feed belongs to an animal feed category
    public function category()
    {
       return $this->belongsTo(\App\Models\AnimalFeedCategory::class, 'animal_feed_category_id');
    }


    //animal feed belongs to a user
     public function vendor()
     {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
     }




     //belongs to an address
    public function address()
    {
       return $this->belongsTo(\App\Models\Address::class,'address_id');
     }




     //belongs to a vendor category
     public function vendor_category()
    {
        return $this->belongsTo(\App\Models\VendorCategory::class,'vendor_category_id');
    }


    //belongs to an animal feed category
    public function animal_feed_category()
    {
        return $this->belongsTo(\App\Models\AnimalFeedCategory::class, 'animal_feed_category_id');
    }




    //Accessors


    public function getImageAttribute($image)
    {

        if ($image) {
            return $this->dir.$image;
         }

    }

    //belongs to many carts
    public function carts()
    {
        return $this->belongsToMany(\App\Models\Cart::class,'animal_feed_cart', 'cart_id', 'animal_feed_id');
    }


}
