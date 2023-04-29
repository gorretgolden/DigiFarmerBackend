<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use URL;
use Storage;
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
    public $dir = 'storage/categories/';



    public $fillable = [
        'name',
        'type',
        'is_active',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'type'=>'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100|unique:categories',
        'image' => 'required',
        'image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        'type'=>'required|string'

    ];


    //a category has many crops
    public function crops()
    {
        return $this->hasMany(\App\Models\Crop::class, 'category_id');
    }

    //has many sub categories

    public function sub_categories()
    {
        return $this->hasMany(\App\Models\SubCategory::class, 'category_id');
    }


    public function getImageAttribute($value)
       {


        return $this->dir.$value;
       }






}
