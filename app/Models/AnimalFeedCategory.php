<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnimalFeedCategory
 * @package App\Models
 * @version November 29, 2022, 10:57 am UTC
 *
 * @property string $name
 */
class AnimalFeedCategory extends Model
{


    use HasFactory;

    public $table = 'animal_feed_categories';





    public $fillable = [
        'name',
        'animal_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'animal_category_id'=>'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'animal_category_id'=>'required|integer'
    ];

    //has many animal feed sub categories
    public function sub_categories()
    {
        return $this->hasMany(\App\Models\AnimalFeedSubCategory::class, 'animal_feed_category_id');
    }

   //has many animal feed categories
    public function animal_category()
    {
        return $this->belongsTo(\App\Models\AnimalCategory::class, 'animal_category_id');
    }


    //has many animal feeds
    public function animal_feeds()
    {
        return $this->hasMany(\App\Models\AnimalFeed::class, 'animal_feed_category_id');
    }

}
