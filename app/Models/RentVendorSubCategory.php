<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RentVendorService;

/**
 * Class RentVendorSubCategory
 * @package App\Models
 * @version December 3, 2022, 8:38 am UTC
 *
 * @property string $name
 * @property integer $rent_vendor_category_id
 */
class RentVendorSubCategory extends Model
{


    use HasFactory;

    public $table = 'rent_vendor_sub_categories';



    public $fillable = [
        'name',
        'rent_vendor_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'rent_vendor_category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'rent_vendor_category_id' => 'required|integer'
    ];


    //has many rent vendor services
    public function rent_vendor_services()
    {
    return $this->hasMany(\App\Models\RentVendorService::class, 'rent_vendor_sub_category_id');
    }

    //belongs to a rent category
    public function rent_category()
    {
    return $this->belongsTo(\App\Models\RentVendorCategory::class, 'rent_vendor_category_id');
    }



}
