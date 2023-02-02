<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use URL;
use Storage;

/**
 * Class AnimalCategory
 * @package App\Models
 * @version December 14, 2022, 7:50 am UTC
 *
 * @property string $name
 * @property string $image
 */
class AnimalCategory extends Model
{


    use HasFactory;

    public $table = 'animal_categories';
    public $dir = 'storage/animal_categories/';






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
        'name' => 'required|string',
        'image' => 'required'
    ];


    //Accessors
    public function getImageAttribute($value)
    {


     return $this->dir.$value;
    }



    //belongs to an animal category
    public function animal_feed_categories()
    {
        return $this->hasMany(\App\Models\AnimalFeedCategory::class, 'animal_category_id');
    }

    //belongs to many vet services
    public function vet_services()
    {
        return $this->belongsToMany(\App\Models\Veterinary::class);
    }
}
