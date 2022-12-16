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
        'image' => 'nullable'
    ];


    //Accessors
    public function getImageAttribute($image)
       {
        //  $image = $this->attributes['image'] ? URL::to('/animal_categories/' . $this->attributes['image']) : null;
        //  return $image;

        if($image){
            $url = Storage::disk('local')->url('public/animal_categories/'.$image);
            return $url;
        }
       }
}
