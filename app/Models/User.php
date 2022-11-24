<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Eloquent as Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
class User extends Authenticable implements  MustVerifyEmail

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
        'phone' => 'required|unique:users,id',
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

       //a user belongs to a district
       public function district()
       {
           return $this->belongsTo(\App\Models\District::class, 'district_id');
       }


      //a user belongs to a specific role
      public function role()
      {
          return $this->belongsTo(\Spatie\Permission\Models\Role::class, 'role_id');
      }

     //a user has many farms
     public function farms()
     {
         return $this->hasMany(\App\Models\Farm::class, 'user_id');
     }

       //a user has many crops on sale
       public function crops_on_sale()
       {
           return $this->hasMany(\App\Models\CropOnSale::class, 'user_id');
       }

         //a user has one crop buyer
      public function crop_buyer()
      {
          return $this->hasOne(\App\Models\CropBuyer::class, 'user_id');
      }

      //a user has many through crop orders

      public function crop_orders()
      {
          $this->hasManyThrough(\App\Models\CropOrder::class, \App\Models\CropOnSale::class, 'user_id', 'crop_on_sale_id');
      }


       //a user has many  finance vendor services
       public function finance_vendor_services()
       {
          return $this->hasMany(\App\Models\FinanceVendorService::class,'user_id');
       }

      public function sendPasswordResetNotification($token)
     {

         $url = 'https://spa.test/reset-password?token=' . $token;

         $this->notify(new ResetPasswordNotification($url));
     }


}
