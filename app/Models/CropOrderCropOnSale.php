<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CropOnSaleCropOrder
 * @package App\Models
 * @version November 20, 2022, 12:52 pm UTC
 *
 * @property integer $crop_on_sale_id
 * @property integer $crop_buyer_id
 */
class CropOrderCropOnSale extends Model
{


    use HasFactory;

    public $table = 'crop_on_sale_crop_order';



    public $fillable = [
        'crop_on_sale_id',
        'crop_order_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'crop_on_sale_id' => 'integer',
        'crop_order_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'crop_on_sale_id' => 'required|integer',
        'crop_order_id' => 'required|integer'
    ];

    //an order product belongs to a crop on sale
    public function crop_on_sale()
    {
        return $this->belongsTo(\App\Models\CropOnSale::class);
    }

    public function crop_orders(){
        return $this->belongsTo(\App\Models\Orders::class);
    }

}
