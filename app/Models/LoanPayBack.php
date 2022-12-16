<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LoanPayBack
 * @package App\Models
 * @version December 15, 2022, 10:58 am UTC
 *
 * @property string $name
 */
class LoanPayBack extends Model
{

    use HasFactory;

    public $table = 'loan_pay_backs';




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

    //has many finances
    public function finance_vendor_services()
     {
        return $this->hasMany(\App\Models\FinanceVendorService::class,'loan_pay_back_id');
     }
}
