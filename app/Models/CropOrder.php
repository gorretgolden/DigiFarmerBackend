<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CropBuyer
 * @package App\Models
 * @version November 9, 2022, 11:28 pm UTC
 *
 * @property integer $buying_price
 * @property integer $crop_on_sale_id
 * @property string $status
 * @property boolean $is_bought
 */
class CropOrder extends Model
{


    use HasFactory;

    public $table = 'crop_orders';


    public $fillable = [
        'buying_price',
        'is_accepted',
        'is_bought',
        'user_id',
        'address_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'buying_price' => 'integer',
        'is_accepted' => 'boolean',
        'is_bought' => 'boolean',
        'user_id' => 'integer',
        'crop_on_sale_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

        'buying_price'=>'required|numeric',
        'is_bought' => 'nullable',
        'is_accepted' => 'nullable',
        'crop_on_sale_id' => 'integer|required',

    ];


  //a crop order belongs to a crop on sale
   public function crop_on_sale()
   {
      return $this->belongsTo(\App\Models\CropOnSale::class,'crop_on_sale_id');
   }


     //a  crop order belongs to a user
     public function user()
     {
         return $this->belongsTo(\App\Models\User::class, 'user_id');
     }

    //  //a crop order has many crop onsale crop orders
    //  public function orders(){
    //     return $this->hasMany(\App\Models\CropOnSaleCropOrder::class, 'crop_on_sale_id');
    // }

}
