<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Category
 * @package App\Models
 * @version November 3, 2022, 7:11 pm UTC
 *
 * @property string $name
 * @property string $image
 */
class Category extends Model
{


    use HasFactory;

    public $table = 'categories';






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
        'name' => 'required|string|max:100',
        'image' => 'nullable'
    ];


    //a category has many sub_categories
    public function sub_categories()
    {
        return $this->hasMany(\App\Models\SubCategory::class, 'category_id');
    }

}
