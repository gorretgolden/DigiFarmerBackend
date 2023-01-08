<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Address
 * @package App\Models
 * @version December 23, 2022, 12:13 pm CET
 *
 * @property integer $country_id
 * @property string $district_name
 * @property string $address_name
 * @property integer $user_id
 */
class Address extends Model
{

    use HasFactory;

    public $table = 'addresses';




    public $fillable = [
        'country_id',
        'district_name',
        'address_name',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'country_id' => 'integer',
        'district_name' => 'string',
        'address_name' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'country_id' => 'required|integer',
        'district_name' => 'required|string',
        'address_name' => 'required|string',
        'user_id' => 'required|integer'
    ];



      //belongs to a user

      public function user()
      {
          return $this->belongsTo(\App\Models\User::class,'user_id');
      }


      //belongs to a country
      public function country()
      {
          return $this->belongsTo(\App\Models\Country::class,'country_id');
      }


      //has many farms
      public function farms()
      {
         return $this->hasMany(\App\Models\Farm::class,'address_id');
      }

      //has many crops on sale
      public function crops_on_sale()
      {
         return $this->hasMany(\App\Models\CropOnSale::class,'address_id');
      }


      //has many seller farm machinary

      public function seller_products()
      {
         return $this->hasMany(\App\Models\SellerProduct::class,'address_id');
      }

      //has many animal feeds
      public function animal_feeds()
     {
        return $this->hasMany(\App\Models\AnimalFeed::class,'address_id');
      }


}
