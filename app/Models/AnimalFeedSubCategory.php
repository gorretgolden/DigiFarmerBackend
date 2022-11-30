<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnimalFeedSubCategory
 * @package App\Models
 * @version November 29, 2022, 9:49 am UTC
 *
 * @property string $name
 * @property integer $animal_feed_category_id
 */
class AnimalFeedSubCategory extends Model
{


    use HasFactory;

    public $table = 'animal_feed_sub_categories';



    public $fillable = [
        'name',
        'animal_feed_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'animal_feed_category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'animal_feed_category_id' => 'required|integer'
    ];

     //an animal feed sub category belongs to an animal feed category
     public function category()
     {
         return $this->belongsTo(\App\Models\AnimalFeedCategory::class, 'animal_feed_category_id');
     }

      //an animal feed sub_category has many animal feeds
     public function animal_feeds()
    {
     return $this->hasMany(\App\Models\AnimalFeed::class, 'animal_feed_sub_category_id');
    }




}
