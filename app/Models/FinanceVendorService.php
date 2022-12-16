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
        'name',
        'principal',
        'interest_rate',
        'interest_rate_unit',
        'payment_frequency_pay',
        'status',
        'simple_interest',
        'total_amount_paid_back',
        'vendor_category_id',
        'user_id',
        'loan_plan_id',
        'finance_vendor_category_id',
        'loan_number'
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
        'status' => 'string',
        'simple_interest' => 'integer',
        'total_amount_paid_back' => 'integer',
        'vendor_category_id' => 'integer',
        'user_id' => 'integer',
        'loan_plan_id' => 'integer',
        'loan_pay_back_id' => 'integer',
        'finance_vendor_category_id' => 'integer',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'principal' => 'required|numeric|min:10000',
        'interest_rate' => 'required|integer|numeric|min:1|max:20',
        'interest_rate_unit' => 'nullable',
        'payment_frequency_pay' => 'nullable',
        'status' => 'required',
        'simple_interest' => 'nullable',
        'total_amount_paid_back' => 'nullable',
        'vendor_category_id' => 'required|integer',
        'user_id' => 'required|integer',
        'loan_plan_id' => 'integer|required',
        'loan_pay_back_id' => 'integer|required',
        'finance_vendor_category_id' => 'required|integer',
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

        //belongs to a loan plan
        public function loan_plan()
        {
           return $this->belongsTo(\App\Models\LoanPlan::class,'loan_plan_id');
        }

         //belongs to a loan pay back frequency
          public function loan_pay_back()
        {
           return $this->belongsTo(\App\Models\LoanPayBack::class,'loan_pay_back_id');
          }

        //belongs to a finance vendor category
        public function finance_vendor_category()
        {
         return $this->belongsTo(\App\Models\FinanceVendorCategories::class,'finance_vendor_category_id');
        }




}
