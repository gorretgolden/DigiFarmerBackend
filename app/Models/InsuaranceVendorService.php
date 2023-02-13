<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class InsuaranceVendorService
 * @package App\Models
 * @version February 8, 2023, 7:46 pm CET
 *
 * @property string $name
 * @property string $terms
 * @property string $image
 * @property string $description
 * @property boolean $is_verified
 * @property string $location
 * @property integer $user_id
 * @property integer $vendor_category_id
 */
class InsuaranceVendorService extends Model
{

    use HasFactory;

    public $table = 'insuarance_vendor_services';
    public $dir = 'storage/insuarance_services/';



    public $fillable = [
        'name',
        'terms',
        'image',
        'description',
        'is_verified',
        'location',
        'user_id',
        'vendor_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'terms' => 'string',
        'image' => 'string',
        'description' => 'string',
        'is_verified' => 'boolean',
        'location' => 'string',
        'user_id' => 'integer',
        'vendor_category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100|min:10|unique:insuarance_vendor_services',
        'terms' => 'required|string|min:10',
        'image' => 'required',
        'description' => 'required|min:10',
        'is_verified' => 'nullable',
        'location' => 'required|string',
        'user_id' => 'required|integer',
        'vendor_category_id' => 'nullable'
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
