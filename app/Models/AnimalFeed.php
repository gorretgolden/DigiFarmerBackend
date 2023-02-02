<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnimalFeed
 * @package App\Models
 * @version November 29, 2022, 10:13 am UTC
 *
 * @property string $name
 * @property integer $animal_feed_sub_category_id
 * @property integer $price
 * @property string $price_unit
 * @property string $description
 */
class AnimalFeed extends Model
{


    use HasFactory;

    public $table = 'animal_feeds';
    public $dir = 'storage/animal_feeds/';


    public $fillable = [
        'name',
        'animal_feed_category_id',
        'animal_category_id',
        'vendory_category_id',
        'price',
        'price_unit',
        'description',
        'user_id',
        'image',
        'weight',
        'weight_unit',
        'address_id',

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'animal_feed_category_id' => 'integer',
        'price' => 'integer',
        'price_unit' => 'string',
        'description' => 'string',
        'user_id' => 'integer',
        'image' => 'string',
        'weight' => 'integer',
        'animal_category_id' => 'integer',
        'address_id' => 'integer',
        'vendor_category_id' => 'integer',
        'weight_unit' => 'string'



    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|unique:animal_feeds',
        'animal_feed_category_id' => 'required|integer',
        'price' => 'required|integer',
        'price_unit' => 'nullable',
        'description' => 'required|min:10',
        'user_id' => 'required|integer',
        'image' => 'required',
        'weight' => 'required|integer',
        'weight_unit' => 'required|string'


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
    public function getImageAttribute($value)
    {


     return $this->dir.$value;
    }

}
