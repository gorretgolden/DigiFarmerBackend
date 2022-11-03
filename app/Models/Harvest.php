<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Harvest
 * @package App\Models
 * @version November 2, 2022, 7:51 am UTC
 *
 * @property integer $farm_id
 * @property integer $harvest_amount
 */
class Harvest extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'harvests';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'farm_id',
        'harvest_amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'farm_id' => 'integer',
        'harvest_amount' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'farm_id' => 'required',
        'harvest_amount' => 'required'
    ];

    
}
