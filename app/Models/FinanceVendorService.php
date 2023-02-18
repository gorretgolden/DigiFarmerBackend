<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FinanceVendorService
 * @package App\Models
 * @version February 17, 2023, 2:00 pm CET
 *
 * @property string $name
 * @property integer $principal
 * @property integer $interest_rate
 * @property string $interest_rate_unit
 * @property integer $payment_frequency_pay
 * @property boolean $is_verified
 * @property integer $simple_interest
 * @property integer $total_amount_paid_back
 * @property integer $vendor_category_id
 * @property integer $user_id
 * @property integer $loan_plan_id
 * @property integer $loan_pay_back_id
 * @property integer $finance_vendor_category_id
 * @property string $location
 * @property string $terms
 * @property integer $payment_frequency_pay
 * @property string $image
 */
class FinanceVendorService extends Model
{

    use HasFactory;

    public $table = 'finance_vendor_services';
    public $dir = 'storage/finance/';



    public $fillable = [
        'name',
        'principal',
        'interest_rate',
        'interest_rate_unit',
        'payment_frequency_pay',
        'is_verified',
        'simple_interest',
        'total_amount_paid_back',
        'vendor_category_id',
        'user_id',
        'loan_plan_id',
        'loan_pay_back',
        'location',
        'terms',
        'image',
        'address_id',
        'document_type'
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
        'is_verified' => 'boolean',
        'simple_interest' => 'integer',
        'total_amount_paid_back' => 'integer',
        'vendor_category_id' => 'integer',
        'user_id' => 'integer',
        'loan_plan_id' => 'integer',
        'loan_pay_back' => 'string',
        'location' => 'string',
        'terms' => 'string',
        'image' => 'string',
        'address_id'=>'integer',
        'document_type'=>'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'principal' => 'required|integer',
        'interest_rate' => 'required|integer',
        'interest_rate_unit' => 'nullable',
        'payment_frequency_pay' => 'nullable',
        'is_verified' => 'nullable',
        'simple_interest' => 'nullable',
        'total_amount_paid_back' => 'nullable',
        'vendor_category_id' => 'nullable',
        'user_id' => 'required|integer',
        'loan_plan_id' => 'required|integer',
        'loan_pay_back' => 'required|string',
        'location' => 'nullable',
        'terms' => 'required|string|min:10',
        'payment_frequency_pay' => 'nullable',
        'image' => ['image','required','mimes:jpg,png,jpeg','max:500','dimensions:min_width=100,min_height=100,max_width=500,max_height=500'],
        'address_id'=>'required|integer',
        'document_type'=>'required|string'
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


     public function getImageAttribute($image)
     {


         if ($image) {
             return $this->dir.$image;
          }


     }

     //has many loan applications
       //belongs to a finance vendor category
       public function loan_applications()
       {
        return $this->hasMany(\App\Models\LoanApplication::class,'finance_vendor_service_id');
       }




}
