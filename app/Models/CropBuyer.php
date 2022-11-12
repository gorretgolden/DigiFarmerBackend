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
        'status',
        'is_bought'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'buying_price' => 'integer',
        'crop_on_sale_id' => 'integer',
        'status' => 'string',
        'is_bought' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'buying_price' => 'required',
        'crop_on_sale_id' => 'required',
        'status' => 'required',
        'is_bought' => 'nullable'
    ];


}
