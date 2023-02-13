<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AgronomistVendorService
 * @package App\Models
 * @version February 9, 2023, 12:57 pm CET
 *
 * @property string $name
 * @property string $expertise
 * @property integer $charge
 * @property boolean $is_verified
 * @property string $location
 * @property string $charge_unit
 * @property string $availability
 * @property string $description
 * @property string $zoom_details
 * @property integer $user_id
 * @property string $image
 * @property integer $vendor_category_id
 */
class AgronomistVendorService extends Model
{

    use HasFactory;

    public $table = 'agronomists';
    public $dir = 'storage/agronomists/';

    public $fillable = [
        'name',
        'expertise',
        'charge',
        'is_verified',
        'location',
        'charge_unit',
        'availability',
        'description',
        'zoom_details',
        'user_id',
        'image',
        'vendor_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'expertise' => 'string',
        'charge' => 'integer',
        'is_verified' => 'boolean',
        'location' => 'string',
        'charge_unit' => 'string',
        'availability' => 'string',
        'description' => 'string',
        'zoom_details' => 'string',
        'user_id' => 'integer',
        'image' => 'string',
        'vendor_category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|min:10',
        'expertise' => 'required|string|min:10',
        'charge' => 'required|integer',
        'is_verified' => 'nullable',
        'location' => 'nullable|string',
        'charge_unit' => 'nullable',
        'availability' => 'required|string',
        'description' => 'required|min:10',
        'zoom_details' => 'nullable',
        'user_id' => 'required|integer',
        'image' => 'required',
        'vendor_category_id' => 'nullable'
    ];


     //belongs to a user
     public function user()
     {
         return $this->belongsTo(\App\Models\User::class,'user_id');
     }



     //belongs to a vendor category
     public function vendor_category()
     {
         return $this->belongsTo(\App\Models\VendorCategory::class,'vendor_category_id');
     }




     //has many agronomist schedules
     public function agronomist_schedules()
     {
         return $this->hasMany(\App\Models\AgronomistShedule::class, 'agronomist_id');
     }



     public function getImageAttribute($value)
     {
      return $this->dir.$value;
     }





     //belongs to may crops
     public function crops()
     {
         return $this->belongsToMany(\App\Models\Crop::class,'agronomist_crop','agronomist_id','crop_id');
     }






}
