<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Veterinary
 * @package App\Models
 * @version January 23, 2023, 6:21 am CET
 *
 * @property string $name
 * @property string $expertise
 * @property integer $charge
 * @property string $location
 * @property string $charge_unit
 * @property string $availability
 * @property string $description
 * @property string $zoom_details
 * @property string $image
 * @property integer $user_id
 * @property integer $vendor_category_id
 */
class Veterinary extends Model
{

    use HasFactory;

    public $table = 'veterinaries';
    public $dir = 'storage/vet/';



    public $fillable = [
        'name',
        'expertise',
        'charge',
        'location',
        'charge_unit',
        'availability',
        'description',
        'zoom_details',
        'image',
        'user_id',
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
        'location' => 'string',
        'charge_unit' => 'string',
        'availability' => 'string',
        'description' => 'string',
        'zoom_details' => 'string',
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
        'expertise' => 'required|string|min:20|max:200',
        'charge' => 'required|integer',
        'location' => 'nullable',
        'charge_unit' => 'nullable',
        'availability' => 'required|string',
        'description' => 'required|string|min:20|max:200',
        'zoom_details' => 'nullable|string',
        'image' => 'required|image',
        'user_id' => 'required|integer',
        'vendor_category_id' => 'required|integer'
    ];



    //belongs to many animal categories
    public function animal_categories()
    {
        return $this->belongsToMany(\App\Models\AnimalCategory::class);
    }


    public function getImageAttribute($value)
    {


     return $this->dir.$value;
    }


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


      //has many vet schedules
      public function vet_schedules()
      {
          return $this->hasMany(\App\Models\VeterinaryShedule::class, 'veterinary_id');
      }



}
