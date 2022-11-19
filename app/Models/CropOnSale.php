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
        'quantity_unit',
        'selling_price',
        'price_unit',
        'description',
        'image',
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
        'quantity_unit'=> 'string',
        'selling_price' => 'integer',
        'price_unit' => 'string',
        'description' => 'string',
        'image' => 'string',
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
        'quantity' => 'required',
        'quantity_unit' => 'required|string',
        'selling_price' => 'required|integer',
        'price_unit' => 'required',
        'description' => 'required',
        'image' => 'required',
        'crop_id' => 'required:integer',

    ];

   //a crop  on sale belongs to a crop
   public function crop()
   {
      return $this->belongsTo(\App\Models\Crop::class,'crop_id');
   }

   //a crop on sale belongs to a user
   public function user()
   {
       return $this->belongsTo(\App\Models\User::class, 'user_id');
   }


}
