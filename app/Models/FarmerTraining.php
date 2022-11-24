<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FarmerTraining
 * @package App\Models
 * @version November 22, 2022, 8:13 am UTC
 *
 * @property boolean $is_registered
 * @property integer $training_vendor_service_id
 * @property integer $user_id
 */
class FarmerTraining extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'farmer_trainings';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'is_registered',
        'training_vendor_service_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_registered' => 'boolean',
        'training_vendor_service_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'is_registered' => 'nullable',
        'training_vendor_service_id' => 'required|integer',
        'user_id' => 'required|integer'
    ];

    
}
