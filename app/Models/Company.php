<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Company
 * @package App\Models
 * @version November 2, 2022, 9:09 am UTC
 *
 * @property string $name
 * @property string $logo
 * @property string $description
 * @property string $contact
 * @property string $email
 * @property integer $crop_price
 * @property integer $crop_id
 */
class Company extends Model
{


    use HasFactory;

    public $table = 'companies';


    //protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'logo',
        'description',
        'contact',
        'email',
        'crop_price',
        'crop_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'logo' => 'string',
        'description' => 'string',
        'contact' => 'string',
        'email' => 'string',
        'crop_price' => 'integer',
        'crop_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'logo' => 'nullable',
        'description' => 'nullable',
        'contact' => 'required',
        'email' => 'required',
        'crop_price' => 'required',
        'crop_id' => 'required'
    ];


      //a country has many users
      public function country()
      {
          return $this->hasMany(\App\Models\User::class, 'country_id');
      }

}
