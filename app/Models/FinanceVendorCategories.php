<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FinanceVendorCategories
 * @package App\Models
 * @version February 17, 2023, 8:18 pm CET
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
        'name' => 'required|text',
        'image' => 'nullable'
    ];


    //has many loan applications
    public function loan_applications()
    {
     return $this->hasMany(\App\Models\LoanApplication::class,'finance_vendor_category_id');
    }


}
