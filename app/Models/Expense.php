<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Expense
 * @package App\Models
 * @version November 2, 2022, 7:29 am UTC
 *
 * @property integer $category_id
 * @property integer $farm_id
 * @property integer $amount
 */
class Expense extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'expenses';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'category_id',
        'farm_id',
        'amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_id' => 'integer',
        'farm_id' => 'integer',
        'amount' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'category_id' => 'required',
        'farm_id' => 'required',
        'amount' => 'required'
    ];

    //an expense belongs to an expense category
      public function expense_category()
      {
         return $this->belongsTo(\App\Models\ExpenseCategory::class);
      }
}
