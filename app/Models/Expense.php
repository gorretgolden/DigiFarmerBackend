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


    use HasFactory;

    public $table = 'expenses';






    public $fillable = [
        'plot_id',
        'expense_category_id',
        'amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'expense_category_id' => 'integer',
        'plot_id' => 'integer',
        'amount' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'expense_category_id' => 'required',
        'plot_id' => 'required',
        'amount' => 'required'
    ];

    //an expense belongs to an expense category
      public function expense_category()
      {
         return $this->belongsTo(\App\Models\ExpenseCategory::class);
      }


      //an expense belongs to a plot
      public function plot()
      {
         return $this->belongsTo(\App\Models\Plot::class,'plot_id');
      }


}
