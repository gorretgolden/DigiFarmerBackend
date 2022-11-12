<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FarmerTraining
 * @package App\Models
 * @version November 10, 2022, 12:06 am UTC
 *
 * @property integer $user_id
 * @property integer $training_vendor_service_id
 * @property string $starting_date
 * @property string $ending_date
 * @property string $access
 * @property integer $period
 * @property string $period_unit
 * @property string $farmer_time
 * @property string $status
 */
class FarmerTraining extends Model
{


    use HasFactory;

    public $table = 'farmer_trainings';


    public $fillable = [
        'user_id',
        'training_vendor_service_id',
        'starting_date',
        'ending_date',
        'access',
        'period',
        'period_unit',
        'farmer_time',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'training_vendor_service_id' => 'integer',
        'starting_date' => 'string',
        'ending_date' => 'string',
        'access' => 'string',
        'period' => 'integer',
        'period_unit' => 'string',
        'farmer_time' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|integer',
        'training_vendor_service_id' => 'required',
        'starting_date' => 'required',
        'ending_date' => 'required',
        'access' => 'required',
        'period' => 'required|integer',
        'period_unit' => 'required',
        'farmer_time' => 'required',
        'status' => 'required'
    ];


}
