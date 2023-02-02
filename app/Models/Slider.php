<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Slider
 * @package App\Models
 * @version November 4, 2022, 12:05 pm UTC
 *
 * @property string $title
 * @property string $image
 */
class Slider extends Model
{


    use HasFactory;

    public $table = 'sliders';
    public $dir = 'storage/sliders/';





    public $fillable = [
        'title',
        'image',
        'type',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'image' => 'string',
        'type' =>'string',
        'is_active'=>'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string',
        'image' => 'image|required',
        'type' => "required|string"
    ];

    public function getImageAttribute($value)
       {

        return $this->dir.$value;
       }
}
