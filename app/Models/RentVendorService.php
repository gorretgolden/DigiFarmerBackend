<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class RentVendorService
 * @package App\Models
 * @version December 3, 2022, 9:01 am UTC
 *
 * @property string $name
 * @property integer $rent_vendor_sub_category_id
 * @property integer $charge
 * @property string $description
 * @property string $images
 */
class RentVendorService extends Model
{


    use HasFactory;

    public $table = 'rent_vendor_services';



    public $fillable = [
        'name',
        'rent_vendor_category_id',
        'charge',
        'description',
        'charge_day',
        'charge_frequency',
        'charge_unit',
        'total_charge',
        'location',
        'user_id',
        'quantity'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'rent_vendor_category_id' => 'integer',
        'charge' => 'integer',
        'description' => 'string',
        'images' => 'string',
        'total_charge' => 'integer',
        'location' => 'string',
        'user_id' => 'integer',
        'charge_day' => 'string',
        'quantity' => 'integer'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|unique:rent_vendor_services|min:10|max:30',
        'rent_vendor_category_id' => 'required|integer',
        'rent_vendor_sub_category_id' => 'required|integer',
        'charge' => 'required|integer',
        'description' => 'required|string|min:20|max:1000',
        'images' => 'required',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        'images' => 'max:3',
        'charge_day'=>'required|integer',
        'charge_frequency'=>'required|string',
        'user_id' => 'required|integer',
        'address_id' => 'required|integer',
        'quantity'=> 'required|integer'

    ];

//rent vendor service has many images
    public function images()
    {
    return $this->hasMany(\App\Models\RentVendorImage::class, 'rent_vendor_service_id');
    }


    //belongs to a vendor
    public function vendor()
    {
    return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

     //belongs to a rendor vendor sub category
     public function rent_vendor_sub_category()
     {
     return $this->belongsTo(\App\Models\RentVendorSubCategory::class, 'rent_vendor_sub_category_id');
     }


}
