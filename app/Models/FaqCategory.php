<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FaqCategory
 * @package App\Models
 * @version December 19, 2022, 9:00 pm CET
 *
 * @property string $name
 * @property string $image
 */
class FaqCategory extends Model
{

    use HasFactory;

    public $table = 'faq_categories';
    public $dir = 'storage/faqs/';




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
        'name' => 'required|string|max:50',
        'image' => 'required|image|max:2048',
        'image.*' =>'mimes:png,jpg,jpeg'
    ];



    //has many faqs
    public function faqs()
    {
       return $this->hasMany(\App\Models\Faq::class,'faq_category_id');
    }
    public function getImageAttribute($value)
    {


     return $this->dir.$value;
    }

}
