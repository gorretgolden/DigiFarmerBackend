<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class RentVendorCategory
 * @package App\Models
 * @version December 3, 2022, 8:35 am UTC
 *
 * @property string $name
 */
class RentVendorCategory extends Model
{


    use HasFactory;

    public $table = 'rent_vendor_categories';



    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string'
    ];


    //has many rent sub categories
    public function rent_sub_categories()
    {
    return $this->hasMany(\App\Models\RentVendorSubCategory::class, 'rent_vendor_sub_category_id');
    }


}
