<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FinanceVendorCategories
 * @package App\Models
 * @version December 14, 2022, 4:00 am UTC
 *
 * @property string $name
 * @property string $image
 */
class FinanceVendorCategories extends Model
{

    use HasFactory;

    public $table = 'finance_vendor_categories';






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


    public function finances()
    {
       return $this->hasMany(\App\Models\FinanceVendorService::class,'finance_vendor_category_id');
      }




}
