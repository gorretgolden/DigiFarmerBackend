<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VendorCategory
 * @package App\Models
 * @version November 9, 2022, 11:36 pm UTC
 *
 * @property string $name
 */
class VendorCategory extends Model
{


    use HasFactory;

    public $table = 'vendor_categories';


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
        'name' => 'required|max:100'
    ];

     //a vendor category has many training vendor serviceS
     public function training_vendor_serviceS()
     {
        return $this->hasMany(\App\Models\TrainingVendorService::class,'vendor_category_id');
     }

     //a vendor category has many finance vendor services
     public function finance_vendor_services()
     {
        return $this->hasMany(\App\Models\FinanceVendorService::class,'vendor_category_id');
     }



}
