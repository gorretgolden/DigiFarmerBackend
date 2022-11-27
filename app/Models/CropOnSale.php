<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CropOnSale
 * @package App\Models
 * @version November 9, 2022, 11:04 pm UTC
 *
 * @property integer $quantity
 * @property integer $selling_price
 * @property string $price_unit
 * @property string $description
 * @property string $image
 * @property string $status
 * @property integer $crop_id
 * @property integer $user_id
 */
class CropOnSale extends Model
{


    use HasFactory;

    public $table = 'crop_on_sales';



    public $fillable = [
        'quantity',
        'selling_price',
        'price_unit',
        'is_sold',
        'crop_id',
        'user_id'
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
        'is_sold' => 'boolean',
        'crop_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'selling_price' => 'required|integer',
        'crop_id' => 'required:integer',

    ];


     //a crop on sale belongs to a crop
     public function crop()
     {
        return $this->belongsTo(\App\Models\Crop::class,'crop_id');
     }

   //a crop  on sale belongs to many crop buyers
   public function crop_orders()
   {
      return $this->belongsToMany(\App\Models\CropOrder::class,'crop_on_sale_crop_order', 'crop_on_sale_id', 'crop_order_id')->withPivot('buying_price');
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


}
