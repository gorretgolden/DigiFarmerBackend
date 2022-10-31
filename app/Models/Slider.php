<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Slider
 * @package App\Models
 * @version October 31, 2022, 7:41 am UTC
 *
 * @property string $image
 * @property string $title
 */
class Slider extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'sliders';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'image',
        'title'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'string',
        'title' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'image' => 'nullable',
        'title' => 'required|string'
    ];

    
}
