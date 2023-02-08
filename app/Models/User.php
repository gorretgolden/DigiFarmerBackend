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
use Illuminate\Auth\Notifications\ResetPassword;
use Stephenjude\Wallet\Interfaces\Wallet;
use Stephenjude\Wallet\Traits\HasWallet;

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
class User extends Authenticable implements  Wallet

{
    use Notifiable,HasRoles,HasFactory,HasApiTokens,HasWallet;



    public $table = 'users';
    public $dir = 'storage/users/';





    public $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'image_url',
        'country_id',
        'user_type_id',
        'password',
        'confirm-password',
        'is_active'
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
        'phone' => 'string',
        'password' => 'string',
        'email_verified_at' => 'datetime',
        'confirm-password' => 'string',
        'user_type_id' => 'integer',
        'is_active'=>'boolean'
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
        'phone' => 'required|unique:users,id|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9',
        'password' => 'required',
        'email_verified_at' => 'datetime',
        'user_type_id' => 'required|integer',
        'confirm-password'=>'required|same:password',


    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];






    //a user belongs to a user type
    public function userType()
      {
          return $this->belongsTo(\App\Models\UserType::class,'user_type_id');
      }

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
          return $this->hasMany(\App\Models\CropOrder::class,'user_id');
      }


       //a user has many  finance vendor services
       public function finance_vendor_services()
       {
          return $this->hasMany(\App\Models\FinanceVendorService::class,'user_id');
       }

      public function sendPasswordResetNotification($token)
     {

         $url = 'http://127.0.0.1:8000/response-password-reset?token=' . $token;

         $this->notify(new ResetPasswordNotification($url));
     }


     //a user has many products for sell
     //a user has many through crop orders

     public function seller_products()
     {
         return $this->hasMany(\App\Models\SellerProduct::class,'user_id');
     }

     //user(venodr) has many animal feeds
     public function animal_feeds()
     {
      return $this->hasMany(\App\Models\AnimalFeed::class, 'user_id');
     }


     //a user has many farmer trainings
     public function farmer_trainings()
     {
        return $this->hasMany(\App\Models\FarmerTraining::class,'user_id');
     }


     //a vendor has many training vendor services
     public function training_vendor_services()
     {
        return $this->hasMany(\App\Models\TrainingVendorService::class,'user_id');
     }


      //a vendor has many rent vendor services
    public function rent_vendor_services()
    {
    return $this->hasMany(\App\Models\RentVendorServices::class, 'user_id');
    }



    //user has one verification
    public function verifications()
    {
    return $this->hasMany(\App\Models\UserVerification::class, 'user_id');
    }

    //has many chats
    public function chats()
    {
    return $this->hasMany(\App\Models\Chat::class, 'created_by');
    }


    //has many contact  us
    public function contact_us()
    {
        return $this->hasMany(\App\Models\Contact::class,'user_id');
    }


    //has many agro services
    public function agronomist_services()
    {
        return $this->hasMany(\App\Models\AgronomistVendorService::class,'user_id');
    }


    //has many vet services
    public function vet_services()
    {
        return $this->hasMany(\App\Models\Veterinary::class,'user_id');
    }

    public function getImageUrlAttribute($image)
    {

        if ($image) {
            return $this->dir.$image;
         }

    }


    //has many users
    public function addresses()
    {
        return $this->hasMany(\App\Models\Address::class,'user_id');
    }

    //has many insuarance services
    public function insuarance_services()
      {
          return $this->hasMany(\App\Models\InsuaranceVendorService::class,'user_id');
      }



      //has one cart
      public function cart()
      {
          return $this->hasOne(\App\Models\Cart::class, 'user_id');
      }




}
