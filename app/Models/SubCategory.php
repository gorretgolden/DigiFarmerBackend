<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SubCategory
 * @package App\Models
 * @version November 3, 2022, 7:16 pm UTC
 *
 * @property string $name
 * @property integer $category_id
 */
class SubCategory extends Model
{


    use HasFactory;

    public $table = 'sub_categories';


   // protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100',
        'category_id' => 'required|integer'
    ];


}
