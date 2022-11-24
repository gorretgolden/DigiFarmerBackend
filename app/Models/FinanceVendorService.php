<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FinanceVendorService
 * @package App\Models
 * @version November 22, 2022, 9:01 am UTC
 *
 * @property integer $user_id
 * @property integer $principal
 * @property integer $interest_rate
 * @property string $interest_rate_unit
 * @property integer $duration
 * @property string $duration_unit
 * @property string $status
 * @property integer $simple_interest
 * @property integer $total_amount_paid_back
 * @property integer $vendor_category_id
 */
class FinanceVendorService extends Model
{

    use HasFactory;

    public $table = 'finance_vendor_services';



    public $fillable = [
        'user_id',
        'name',
        'principal',
        'interest_rate',
        'interest_rate_unit',
        'duration',
        'duration_unit',
        'status',
        'simple_interest',
        'total_amount_paid_back',
        'vendor_category_id',
        'payment_frequency'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'name' => 'string',
        'principal' => 'integer',
        'interest_rate' => 'integer',
        'interest_rate_unit' => 'string',
        'duration' => 'integer',
        'duration_unit' => 'string',
        'status' => 'string',
        'simple_interest' => 'integer',
        'total_amount_paid_back' => 'integer',
        'vendor_category_id' => 'integer',
        'payment_frequency' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'principal' => 'required|integer',
        'name' => 'string|unique:finance_vendor_services',
        'interest_rate' => 'required|integer',
        'interest_rate_unit' => 'nullable',
        'duration' => 'required|integer',
        'duration_unit' => 'nullable',
        'status' => 'nullable',
        'simple_interest' => 'nullable',
        'total_amount_paid_back' => 'nullable',
        'vendor_category_id' => 'required|integer',
        'payment_frequency' => 'required|string'
    ];



       //a finance vendor service belongs to vendor category
       public function vendor_category()
       {
          return $this->belongsTo(\App\Models\VendorCategory::class,'vendor_category_id');
       }


        //a finance vendor service belongs to a user
        public function user()
        {
           return $this->belongsTo(\App\Models\User::class,'user_id');
        }

}
