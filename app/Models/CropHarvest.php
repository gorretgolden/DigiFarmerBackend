<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CropHarvest
 * @package App\Models
 * @version November 18, 2022, 2:13 am UTC
 *
 * @property integer $plot_id
 * @property integer $quantity
 * @property string $quantity_unit
 */
class CropHarvest extends Model
{


    use HasFactory;

    public $table = 'crop_harvests';





    public $fillable = [
        'plot_id',
        'quantity',
        'quantity_unit'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'plot_id' => 'integer',
        'quantity' => 'integer',
        'quantity_unit' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'plot_id' => 'required|integer',
        'quantity' => 'required|integer',
        'quantity_unit' => 'required|string'
    ];


}
