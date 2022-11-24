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
        'user_id'
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
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'buying_price' => 'required|integer',
        'is_bought' => 'nullable',
        'is_accepted' => 'nullable'
    ];


  //a crop order belongs to many crops on sale
   public function crops_on_sale()
   {
      return $this->belongsToMany(\App\Models\CropOnSale::class);
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
