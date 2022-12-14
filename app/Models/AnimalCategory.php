<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


}
