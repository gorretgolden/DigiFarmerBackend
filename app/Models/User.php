<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Spatie\Permission\Models\Role;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @version October 8, 2022, 11:18 am UTC
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $image_url
 * @property integer $country_id
 * @property integer $role_id
 * @property string $password
 */
class User extends Authenticable
{
    use SoftDeletes,Notifiable,HasRoles,HasFactory,HasApiTokens;



    public $table = 'users';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'image_url',
        'country_id',
        'user_type',
        'password',
        'confirm-password',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'image_url' => 'string',
        'country_id' => 'integer',
        'user_type' => 'string',
        'phone' => 'string',
        'password' => 'string',
        'email_verified_at' => 'datetime',
        'confirm-password' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|unique:users,id|email',
        'image_url' => 'nullable',
        'country_id' => 'nullable',
        'password' => 'required',
        'email_verified_at' => 'datetime',
        'user_type' => 'required|string',
        'confirm-password'=>'required|same:password'

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

      //a user belongs to a country
      public function country()
      {
          return $this->belongsTo(\App\Models\Country::class, 'country_id');
      }

      //a user belongs to a specific role
      public function role()
      {
          return $this->belongsTo(\Spatie\Permission\Models\Role::class, 'role_id');
      }

     //a user
     public function farms()
     {
         return $this->hasMany(\App\Models\Farm::class, 'user_id');
     }


     public function sendPasswordResetNotification($token)
     {

         $url = 'https://spa.test/reset-password?token=' . $token;

         $this->notify(new ResetPasswordNotification($url));
     }


}
