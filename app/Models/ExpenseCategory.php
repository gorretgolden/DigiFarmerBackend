<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ExpenseCategory
 * @package App\Models
 * @version November 4, 2022, 12:51 pm UTC
 *
 * @property string $name
 * @property integer $standard_value
 * @property string $description
 */
class ExpenseCategory extends Model
{

    use HasFactory;

    public $table = 'expense_categories';






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
        'name' => 'required|string|unique:expense_categories',
        'standard_value' => 'required|integer',
        'description' => 'nullable'
    ];


}
