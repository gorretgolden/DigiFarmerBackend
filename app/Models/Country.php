<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Country
 * @package App\Models
 * @version October 31, 2022, 7:45 am UTC
 *
 * @property string $name
 * @property string $short_code
 */
class Country extends Model
{


    use HasFactory;

    public $table = 'countries';


   // protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'short_code',
        'country_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'short_code' => 'string',
        'country_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'short_code' => 'required|string',
        'country_code' => 'required|string',
    ];


      //a country has many users
      public function users()
      {
          return $this->hasMany(\App\Models\User::class, 'country_id');
      }

      //a country has many districts
      public function districts()
      {
          return $this->hasMany(\App\Models\District::class, 'country_id');
      }


      //has many address
      public function addresses()
      {
          return $this->belongsToMany(\App\Models\Address::class,'country_id');
      }

}
