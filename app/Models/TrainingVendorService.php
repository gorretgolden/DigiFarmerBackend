<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TrainingVendorService
 * @package App\Models
 * @version November 22, 2022, 8:00 am UTC
 *
 * @property string $name
 * @property integer $charge
 * @property string $description
 * @property integer $period
 * @property string $period_unit
 * @property string $access
 * @property string $starting_date
 * @property string $ending_date
 * @property string $starting_time
 * @property string $ending_time
 * @property string $zoom_details
 * @property string $location_details
 * @property integer $vendory_category_id
 * @property integer $user_id
 */
class TrainingVendorService extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'training_vendor_services';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'charge',
        'description',
        'period',
        'period_unit',
        'access',
        'starting_date',
        'ending_date',
        'starting_time',
        'ending_time',
        'zoom_details',
        'location_details',
        'vendory_category_id',
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
        'period' => 'integer',
        'period_unit' => 'string',
        'access' => 'string',
        'starting_date' => 'string',
        'ending_date' => 'string',
        'starting_time' => 'string',
        'ending_time' => 'string',
        'zoom_details' => 'string',
        'location_details' => 'string',
        'vendory_category_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|unique:training_vendor_services',
        'charge' => 'required|integer',
        'description' => 'required|string',
        'period' => 'required|integer',
        'period_unit' => 'nullable|string',
        'access' => 'nullable',
        'starting_date' => 'required',
        'ending_date' => 'required',
        'starting_time' => 'required',
        'ending_time' => 'required',
        'zoom_details' => 'nullable',
        'location_details' => 'nullable',
        'vendory_category_id' => 'required|integer',
        'user_id' => 'required|integer'
    ];


       //a traning vendor service belongs to vendor category
       public function vendor_category()
       {
          return $this->belongsTo(\App\Models\VendorCategory::class,'vendor_category_id');
       }

}
