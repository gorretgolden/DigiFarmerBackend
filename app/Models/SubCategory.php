<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;

/**
 * Class SubCategory
 * @package App\Models
 * @version April 21, 2023, 11:52 am CEST
 *
 * @property string $name
 * @property string $image
 * @property boolean $is_active
 * @property integer $category_id
 * @property integer $animal_category_id
 */
class SubCategory extends Model
{

    use HasFactory;

    public $table = 'sub_categories';
    public $dir = 'storage/sub_categories/';





    public $fillable = [
        'name',
        'image',
        'is_active',
        'category_id',
        'animal_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'is_active' => 'boolean',
        'category_id' => 'integer',
        'animal_category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'string|required|max:200',
        'image' => 'required',
        'is_active' => 'nullable',
        'category_id' => 'required|integer',
        'animal_category_id' => 'nullable'
    ];

    //belongs to a category

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }


    //belongs to an animal category
    public function vendor_services()
    {
        return $this->hasMany(\App\Models\VendorServices::class, 'sub_category_id');
    }



    public function getImageAttribute($value)
       {

        return $this->dir.$value;
       }



}
