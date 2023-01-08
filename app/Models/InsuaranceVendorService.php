<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class InsuaranceVendorService
 * @package App\Models
 * @version December 5, 2022, 8:59 pm UTC
 *
 * @property string $name
 * @property string $terms
 * @property string $description
 * @property integer $user_id
 */
class InsuaranceVendorService extends Model
{


    use HasFactory;

    public $table = 'insuarance_vendor_services';
    public $dir = 'storage/insuarance_services/';




    public $fillable = [
        'name',
        'terms',
        'description',
        'user_id',
        'vendor_category_id',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'terms' => 'string',
        'description' => 'string',
        'user_id' => 'integer',
        'vendor_category_id'=>'integer',
        'image'=> 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|unique:insuarance_vendor_services',
        'terms' => 'required|string',
        'description' => 'required|string',
        'user_id' => 'required|integer',
        'image' => 'required|string',


    ];

    //belongs to a vendor category
    public function vendor_category()
    {
        return $this->belongsTo(\App\Models\VendorCategory::class,'vendor_category_id');
    }


    //belongs to a user
    public function user()
      {
          return $this->belongsTo(\App\Models\User::class,'user_id');
      }


      public function getImageAttribute($value)
      {


       return $this->dir.$value;
      }


}
