<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class District
 * @package App\Models
 * @version October 31, 2022, 7:54 am UTC
 *
 * @property string $name
 * @property integer $country_id
 */
class District extends Model
{


    use HasFactory;

    public $table = 'districts';






    public $fillable = [
        'name',
        'country_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'country_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'country_id' => 'nullable'
    ];

    //a district belongs to a country
    public function country()
      {
          return $this->belongsTo(\App\Models\Country::class, 'country_id');
      }

    //a district has many users
    public function users()
    {
        return $this->belongsTo(\App\Models\User::class, 'district_id');
    }



    //a district has many plots
    public function plots()
    {
       return $this->hasMany(\App\Models\Plot::class,'district_id');
    }


}
