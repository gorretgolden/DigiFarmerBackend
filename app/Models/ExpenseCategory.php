<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ExpenseCategory
 * @package App\Models
 * @version November 1, 2022, 11:26 am UTC
 *
 * @property string $name
 * @property integer $standard_value
 * @property string $description
 */
class ExpenseCategory extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'expense_categories';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'standard_value',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'standard_value' => 'integer',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'standard_value' => 'required',
        'description' => 'nullable'
    ];

    //an expense category
    public function expense_category()
    {
       return $this->hasOne(\App\Models\Expense::class);
    }


}
