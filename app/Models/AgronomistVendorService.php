<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AgronomistVendorService
 * @package App\Models
 * @version January 22, 2023, 1:19 pm CET
 *
 * @property string $name
 * @property string $expertise
 * @property integer $charge
 * @property string $charge_unit
 * @property string $availability
 * @property string $description
 * @property string $zoom_details
 * @property string $location
 * @property string $image
 * @property integer $user_id
 * @property integer $vendor_category_id
 */
class AgronomistVendorService extends Model
{

    use HasFactory;

    public $table = 'agronomists';
    public $dir = 'storage/agromomists/';


    public $fillable = [
        'name',
        'expertise',
        'charge',
        'charge_unit',
        'availability',
        'description',
        'zoom_details',
        'location',
        'image',
        'user_id',
        'vendor_category_id',
        'crops',
        'address_id'
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
        'charge_unit' => 'string',
        'availability' => 'string',
        'description' => 'string',
        'zoom_details' => 'string',
        'location' => 'string',
        'image' => 'string',
        'user_id' => 'integer',
        'vendor_category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100',
        'expertise' => 'required|min:10|string',
        'charge' => 'required|integer',
        'charge_unit' => 'nullable',
        'availability' => 'required|string',
        'description' => 'required|min:10',
        'zoom_details' => 'nullable',
        'location' => 'nullable',
        'image' => 'required|image',
        'user_id' => 'required|integer',
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
