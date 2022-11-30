<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnimalFeed
 * @package App\Models
 * @version November 29, 2022, 10:13 am UTC
 *
 * @property string $name
 * @property integer $animal_feed_sub_category_id
 * @property integer $price
 * @property string $price_unit
 * @property string $description
 */
class AnimalFeed extends Model
{


    use HasFactory;

    public $table = 'animal_feeds';


    public $fillable = [
        'name',
        'animal_feed_sub_category_id',
        'price',
        'price_unit',
        'description',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'animal_feed_sub_category_id' => 'integer',
        'price' => 'integer',
        'price_unit' => 'string',
        'description' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'animal_feed_sub_category_id' => 'required|integer',
        'price' => 'required|integer',
        'price_unit' => 'nullable',
        'description' => 'nullable',
        'user_id' => 'required|integer'
    ];

 //an animal feed belongs to an animal feed sub_categories
 public function sub_category()
 {
     return $this->belongsTo(\App\Models\AnimalFeedSubCategory::class, 'animal_feed_sub_category_id');
 }
//nimal feed belongs to a user
 public function vendor()
 {
     return $this->belongsTo(\App\Models\User::class, 'user_id');
 }





}
