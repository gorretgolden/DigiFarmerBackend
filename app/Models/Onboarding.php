<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Onboarding
 * @package App\Models
 * @version December 12, 2022, 6:04 am UTC
 *
 * @property string $title
 * @property string $description
 * @property string $image
 */
class Onboarding extends Model
{


    use HasFactory;

    public $table = 'onboardings';



    public $fillable = [
        'title',
        'description',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string',
        'description' => 'required|string',
        'image' => 'nullable'
    ];


}
