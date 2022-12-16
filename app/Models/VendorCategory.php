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
        'image' => 'nullable'
    ];


    //has many finance vendor services
    public function finance_vendor_services()
    {
        return $this->hasMany(\App\Models\FinanceVendorService::class,'vendor_category_id');
    }

}
