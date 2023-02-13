<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TrainingVendorService
 * @package App\Models
 * @version February 8, 2023, 10:12 pm CET
 *
 * @property string $name
 * @property integer $charge
 * @property string $description
 * @property string $image
 * @property string $access
 * @property boolean $is_verified
 * @property string $starting_date
 * @property string $ending_date
 * @property string $starting_time
 * @property string $ending_time
 * @property string $zoom_details
 * @property string $location
 * @property integer $vendor_category_id
 * @property integer $user_id
 */
class TrainingVendorService extends Model
{

    use HasFactory;

    public $table = 'training_vendor_services';
    public $dir = 'storage/trainings/';



    public $fillable = [
        'name',
        'charge',
        'description',
        'image',
        'access',
        'is_verified',
        'starting_date',
        'ending_date',
        'starting_time',
        'ending_time',
        'zoom_details',
        'location',
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
        'charge' => 'integer',
        'description' => 'string',
        'image' => 'string',
        'access' => 'string',
        'is_verified' => 'boolean',
        'starting_date' => 'string',
        'ending_date' => 'string',
        'starting_time' => 'string',
        'ending_time' => 'string',
        'zoom_details' => 'string',
        'location' => 'string',
        'vendor_category_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|min:10|max:100|unique:training_vendor_services',
        'charge' => 'required|integer',
        'description' => 'required|string|min:10',
        'image' => 'required',
        'access' => 'required|string',
        'is_verified' => 'nullable',
        'starting_date' => 'required',
        'ending_date' => 'required',
        'starting_time' => 'required',
        'ending_time' => 'required',
        'zoom_details' => 'nullable',
        'location' => 'nullable',
        'vendor_category_id' => 'nullable',
        'user_id' => 'required|integer'
    ];

     //a traning vendor service belongs to vendor category
     public function vendor_category()
     {
        return $this->belongsTo(\App\Models\VendorCategory::class,'vendor_category_id');
     }


  //a training vendor service has many farmers for training
   public function farmers()
   {
      return $this->hasMany(\App\Models\User::class,'training_vendor_service_id');
   }


   //a training vendor service belongs to a vendor
   public function vendor()
   {
      return $this->belongsTo(\App\Models\User::class,'user_id');
   }


   public function getImageAttribute($value)
    {

     return $this->dir.$value;
    }





}
