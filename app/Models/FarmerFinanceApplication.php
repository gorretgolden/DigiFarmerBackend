<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FarmerFinanceApplication
 * @package App\Models
 * @version November 22, 2022, 9:55 am UTC
 *
 * @property integer $finance_vendor_service_id
 * @property integer $user_id
 * @property boolean $is_approved
 * @property string $national_id
 * @property string $drivin_permit
 * @property string $land_title
 */
class FarmerFinanceApplication extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'farmer_finance_applications';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'finance_vendor_service_id',
        'user_id',
        'is_approved',
        'national_id',
        'drivin_permit',
        'land_title'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'finance_vendor_service_id' => 'integer',
        'user_id' => 'integer',
        'is_approved' => 'boolean',
        'national_id' => 'string',
        'drivin_permit' => 'string',
        'land_title' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'finance_vendor_service_id' => 'required|integer',
        'user_id' => 'required|integer',
        'is_approved' => 'nullable',
        'national_id' => 'nullable',
        'drivin_permit' => 'nullable',
        'land_title' => 'nullable'
    ];

    
}
