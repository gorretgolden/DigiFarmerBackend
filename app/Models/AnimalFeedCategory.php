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
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string'
    ];

    //has many animal feed sub categories
    public function sub_categories()
    {
        return $this->hasMany(\App\Models\AnimalFeedSubCategory::class, 'animal_feed_category_id');
    }
}
