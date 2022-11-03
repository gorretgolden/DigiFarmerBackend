<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Farm
 * @package App\Models
 * @version October 31, 2022, 8:22 am UTC
 *
 * @property string $name
 * @property integer $district_id
 * @property string $address
 * @property number $latitude
 * @property number $longitude
 * @property number $field_area
 * @property integer $user_id
 */
class Farm extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'farms';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'district_id',
        'address',
        'latitude',
        'longitude',
        'field_area',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'district_id' => 'integer',
        'address' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
        'field_area' => 'double',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'district_id' => 'required',
        'address' => 'required|string',
        'latitude' => 'required',
        'longitude' => 'required',
        'field_area' => 'required',
        'user_id' => 'required'
    ];


    //a farm has many plots

      public function plots()
      {
         return $this->hasMany(\App\Models\Plot::class,'farm_id');
      }





}
