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
class CropBuyer extends Model
{


    use HasFactory;

    public $table = 'crop_buyers';






    public $fillable = [
        'buying_price',
        'crop_on_sale_id',
        'is_accepted',
        'is_bought',
        'contact_one',
        'contact_two',
        'description',
        'email',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'buying_price' => 'integer',
        'crop_on_sale_id' => 'integer',
        'is_accepted' => 'boolean',
        'is_bought' => 'boolean',
        'contact_one' => 'string',
        'contact_two' => 'string',
        'email' => 'string',
        'description' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'buying_price' => 'required|integer',
        'crop_on_sale_id' => 'required|integer',
        'contact_one' => 'string|required',
        'contact_two' => 'string|nullable',
        'email' => 'string|required',
        'description' => 'string',
        'is_bought' => 'nullable',
        'is_accepted' => 'nullable'
    ];


  //a crop buyer has many crops on sale
   public function crops_on_sale()
   {
      return $this->hasMany(\App\Models\CropOnSale::class,'crop_on_sale_id');
   }

}
