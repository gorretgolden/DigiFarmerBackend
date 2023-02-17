<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LoanPlan
 * @package App\Models
 * @version December 15, 2022, 10:15 am UTC
 *
 * @property integer $value
 * @property string $period_unit
 */
class LoanPlan extends Model
{

    use HasFactory;

    public $table = 'loan_plans';


    protected $appends = ['value_period_unit'];


    public $fillable = [
        'value',
        'period_unit'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'integer',
        'period_unit' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'value' => 'required|integer',
        'period_unit' => 'nullable'
    ];

    //has many finance vendor services
    public function finances()
     {
        return $this->hasMany(\App\Models\FinanceVendorService::class,'loan_plan_id');
     }


     //get value period unit

    public function getValuePeriodUnitAttribute()
  {
      return $this->value. ' ' . $this->period_unit;
}
}
