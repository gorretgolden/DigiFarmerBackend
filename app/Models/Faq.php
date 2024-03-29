<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Faq
 * @package App\Models
 * @version December 20, 2022, 3:35 am CET
 *
 * @property integer $faq_category_id
 * @property string $question
 * @property string $answer
 */
class Faq extends Model
{

    use HasFactory;

    public $table = 'faqs';




    public $fillable = [
        'category_id',
        'question',
        'answer',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_id' => 'integer',
        'question' => 'string',
        'answer' => 'string',
        'is_active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'category_id' => 'required|integer',
        'question' => 'required|string|max:50',
        'answer' => 'required|string|max:255'
    ];

    //belongs to fa category
     public function plots()
    {
       return $this->hasMany(\App\Models\Plot::class,'district_id');
    }


    //belongs to faq category
    public function category()
    {
       return $this->belongsTo(\App\Models\Category::class,'category_id');
    }


}
