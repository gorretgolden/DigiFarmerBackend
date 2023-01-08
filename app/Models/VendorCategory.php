<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VendorCategory
 * @package App\Models
 * @version December 12, 2022, 7:49 am UTC
 *
 * @property string $name
 * @property string $image
 */
class VendorCategory extends Model
{
    use HasFactory;

    public $table = 'vendor_categories';
    public $dir = 'storage/vendor_categories/';





    public $fillable = [
        'name',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'image' => 'required|image'
    ];

    //has many training services
    public function training_vendor_services()
    {
        return $this->hasMany(\App\Models\TrainingVendorService::class,'vendor_category_id');
    }

    //has many seller products
    public function farm_equipments()
    {
        return $this->hasMany(\App\Models\SellerProduct::class,'vendor_category_id');
    }

    //has many animal feeds
    public function animal_feeds()
    {
        return $this->hasMany(\App\Models\AnimalFeed::class,'vendor_category_id');
    }

    //has many insuarance services
    public function insuarance_vendors()
    {
        return $this->hasMany(\App\Models\InsuaranceVendorService::class,'vendor_category_id');
    }


    //has many finance vendor services
    public function finance_vendor_services()
    {
        return $this->hasMany(\App\Models\FinanceVendorService::class,'vendor_category_id');
    }

    public function getImageAttribute($image)
    {

        if ($image) {
            return $this->dir.$image;
         }

    }

}
