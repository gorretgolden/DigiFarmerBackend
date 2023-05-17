<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VendorService
 * @package App\Models
 * @version April 21, 2023, 11:23 pm CEST
 *
 * @property string $name
 * @property string $image
 * @property string $price_unit
 * @property integer $price
 * @property string $description
 * @property string $weight_unit
 * @property integer $stock_amount
 * @property boolean $is_verified
 * @property string $expertise
 * @property integer $charge
 * @property string $charge_frequency
 * @property string $zoom_details
 * @property string $location
 * @property string $starting_date
 * @property string $ending_date
 * @property string $starting_time
 * @property string $ending_time
 * @property integer $principal
 * @property string $interest_rate
 * @property string $interest_rate_unit
 * @property integer $payment_frequency_pay
 * @property integer $simple_interest
 * @property string $status
 * @property integer $total_amount_paid_back
 * @property string $document_type
 * @property string $terms
 * @property string $loan_pay_back
 * @property string $access
 * @property integer $loan_plan_id
 * @property integer $sub_category_id
 * @property integer $user_id
 */
class VendorService extends Model
{

    use HasFactory;

    public $table = 'vendor_services';
    public $dir = 'storage/vendor_services/';




    public $fillable = [
        'name',
        'image',
        'price_unit',
        'price',
        'description',
        'weight_unit',
        'stock_amount',
        'is_verified',
        'expertise',
        'charge',
        'charge_frequency',
        'zoom_details',
        'location',
        'starting_date',
        'ending_date',
        'starting_time',
        'ending_time',
        'principal',
        'interest_rate',
        'interest_rate_unit',
        'payment_frequency_pay',
        'simple_interest',
        'status',
        'total_amount_paid_back',
        'document_type',
        'terms',
        'loan_pay_back',
        'access',
        'loan_plan_id',
        'sub_category_id',
        'user_id',
        'address_id',
        'animal_categories',
        'crops',
        'charge_unit'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'price_unit' => 'string',
        'price' => 'integer',
        'description' => 'string',
        'weight_unit' => 'string',
        'stock_amount' => 'integer',
        'is_verified' => 'boolean',
        'expertise' => 'string',
        'charge' => 'integer',
        'charge_frequency' => 'string',
        'zoom_details' => 'string',
        'location' => 'string',
        'starting_date' => 'string',
        'ending_date' => 'string',
        'starting_time' => 'string',
        'ending_time' => 'string',
        'principal' => 'integer',
        'interest_rate' => 'string',
        'interest_rate_unit' => 'string',
        'payment_frequency_pay' => 'integer',
        'simple_interest' => 'integer',
        'status' => 'string',
        'total_amount_paid_back' => 'integer',
        'document_type' => 'string',
        'terms' => 'string',
        'loan_pay_back' => 'string',
        'access' => 'string',
        'loan_plan_id' => 'integer',
        'sub_category_id' => 'integer',
        'user_id' => 'integer',
        'address_id'=>'integer',
        'animal_categories'=>'array',
        'crops'=>'array',
        'charge_unit'=>'string'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:200|unique:vendor_services',
        'image' => 'required|image',
        'image.*' => 'image|mimes:png,jpg,jpeg|max:2048',
        'price_unit' => 'nullable',
        'price' => 'nullable|integer',
        'description' => 'required|string|min:20|max:255',
        'weight_unit' => 'nullable|string',
        'stock_amount' => 'nullable|integer',
        'is_verified' => 'nullable',
        'expertise' => 'nullable|max:255',
        'charge' => 'nullable|integer',
        'charge_frequency' => 'nullable|string',
        'zoom_details' => 'nullable|string',
        'location' => 'nullable|string',
        'starting_date' => 'nullable',
        'ending_date' => 'nullable',
        'starting_time' => 'nullable',
        'ending_time' => 'nullable',
        'principal' => 'nullable|integer',
        'interest_rate' => 'nullable|string',
        'interest_rate_unit' => 'nullable|string',
        'payment_frequency_pay' => 'nullable|integer',
        'simple_interest' => 'nullable|integer',
        'status' => 'nullable|string',
        'total_amount_paid_back' => 'nullable|integer',
        'document_type' => 'nullable|string',
        'terms' => 'nullable|string|min:10',
        'loan_pay_back' => 'nullable|string',
        'access' => 'nullable|string',
        'loan_plan_id' => 'nullable|integer',
        'sub_category_id' => 'required|integer',
        'user_id' => 'required|integer',
        'address_id'=>'required|integer'
    ];


    //belongs to a sub category
    public function sub_category()
    {
        return $this->belongsTO(\App\Models\SubCategory::class, 'sub_category_id');
    }


    //image
    public function getImageAttribute($image)
    {

        if ($image) {
            return asset($this->dir.$image);
         }

    }

    //belongs to a vendor
    public function vendor()
    {
    return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    //a training vendor service has many farmers for training
    public function farmers()
    {
       return $this->hasMany(\App\Models\User::class,'vendor_service_id');
    }

    //animal feed service belongs to many animal categories
    public function animal_categories()
    {
       return $this->belongsToMany(\App\Models\AnimalCategory::class);
    }


    //belongs to many crops
    public function crops()
    {
       return $this->belongsToMany(\App\Models\Crop::class);
    }





}
