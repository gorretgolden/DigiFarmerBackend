<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon;

/**
 * Class CropOnSale
 * @package App\Models
 * @version December 29, 2022, 7:44 am CET
 *
 * @property integer $quantity
 * @property integer $selling_price
 * @property string $price_unit
 * @property string $description
 * @property string $image
 * @property boolean $is_sold
 * @property integer $crop_id
 * @property integer $user_id
 * @property integer $address_id
 */
class CropOnSale extends Model
{

    use HasFactory;

    public $table = 'crop_on_sales';




    public $fillable = [
        'quantity',
        'selling_price',
        'price_unit',
        'description',
        'image',
        'is_sold',
        'crop_id',
        'user_id',
        'address_id',
        'name',

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'quantity' => 'integer',
        'selling_price' => 'integer',
        'price_unit' => 'string',
        'description' => 'string',
        'image' => 'string',
        'is_sold' => 'boolean',
        'crop_id' => 'integer',
        'user_id' => 'integer',
        'address_id' => 'integer',
        'created_at' => 'datetime:d-m-Y'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'quantity' => 'required|integer',
        'selling_price' => 'required|integer',
        'price_unit' => 'nullable',
        'description' => 'required|string',
        'is_sold' => 'nullable',
        'crop_id' => 'required|integer',
        'user_id' => 'required|integer',
        'address_id' => 'required|integer'
    ];


     //a crop on sale belongs to a crop
     public function crop()
     {
        return $this->belongsTo(\App\Models\Crop::class,'crop_id');
     }

   //a crop  on sale has many crop buy requests
   public function crop_buy_requests()
   {
      return $this->hasMany(\App\Models\CropOrder::class,'crop_on_sale_id');
   }

   //a crop on sale belongs to a user
   public function user()
   {
       return $this->belongsTo(\App\Models\User::class, 'user_id');

   }

//    public function getMinPrice()
// {
//     return $this->collect(crop_orders()->min('buying_price'));
// }


//belongs to an address
public function address()
{
   return $this->belongsTo(\App\Models\Address::class,'address_id');
}

//belongs to many saved crops
    //belongs to a crop on sale
    public function saved_crops()
    {
       return $this->hasMany(\App\Models\CropOnSale::class,'crop_on_sale_id');
    }






}
