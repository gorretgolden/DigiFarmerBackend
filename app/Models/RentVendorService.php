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
    public $dir = 'storage/rent/';



    public $fillable = [
        'name',
        'rent_vendor_category_id',
        'charge',
        'description',
        'charge_frequency',
        'charge_unit',
        'location',
        'user_id',
        'quantity',
        'status',
        'image'

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
        'image' => 'string',
        'location' => 'string',
        'user_id' => 'integer',
        'charge_frequency' => 'string',
        'quantity' => 'integer',
        'status' =>'string',
        'created_at' => 'datetime:d-m-Y',
        'image'=>'string'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|unique:rent_vendor_services|min:10|max:50',
        'rent_vendor_category_id' => 'required|integer',
        'rent_vendor_sub_category_id' => 'required|integer',
        'charge' => 'required|integer',
        'description' => 'required|string|min:20|max:1000',
        'image' => 'required',
        'image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        'images' => 'max:1',
        'user_id' => 'required|integer',
        'address_id' => 'required|integer',
        'quantity'=> 'required|integer',
        'charge_frequency'=>'required|string'

    ];

    //rent vendor service has many images
    // public function images()
    // {
    // return $this->hasMany(\App\Models\RentVendorImage::class, 'rent_vendor_service_id','id');
    // }

    public function getImageAttribute($value)
    {


     return $this->dir.$value;
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


     //belongs to a vendor category'
     public function vendor_category()
     {
        return $this->belongsTo(\App\Models\VendorCategory::class,'vendor_category_id');
     }

}
