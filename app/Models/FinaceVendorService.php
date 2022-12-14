<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FinaceVendorService
 * @package App\Models
 * @version December 7, 2022, 11:11 am UTC
 *
 * @property string $name
 * @property integer $principal
 * @property integer $interest_rate
 * @property string $interest_rate_unit
 * @property integer $payment_frequency_pay
 * @property string $duration_unit
 * @property integer $duration
 * @property string $payment_frequency
 * @property string $status
 * @property integer $simple_interest
 * @property integer $total_amount_paid_back
 * @property integer $vendor_category_id
 * @property integer $user_id
 */
class FinaceVendorService extends Model
{


    use HasFactory;

    public $table = 'finance_vendor_services';





    public $fillable = [
        'name',
        'principal',
        'interest_rate',
        'interest_rate_unit',
        'payment_frequency_pay',
        'duration_unit',
        'duration',
        'payment_frequency',
        'status',
        'simple_interest',
        'total_amount_paid_back',
        'vendor_category_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'principal' => 'integer',
        'interest_rate' => 'integer',
        'interest_rate_unit' => 'string',
        'payment_frequency_pay' => 'integer',
        'duration_unit' => 'string',
        'duration' => 'integer',
        'payment_frequency' => 'string',
        'status' => 'string',
        'simple_interest' => 'integer',
        'total_amount_paid_back' => 'integer',
        'vendor_category_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'principal' => 'required',
        'interest_rate' => 'required|integer',
        'interest_rate_unit' => 'nullable',
        'payment_frequency_pay' => 'nullable',
        'duration_unit' => 'nullable',
        'duration' => 'required|integer',
        'payment_frequency' => 'required',
        'status' => 'required',
        'simple_interest' => 'nullable',
        'total_amount_paid_back' => 'nullable',
        'vendor_category_id' => 'required|integer',
        'user_id' => 'required|integer'
    ];


}
