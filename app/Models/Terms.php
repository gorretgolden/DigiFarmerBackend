<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Terms
 * @package App\Models
 * @version December 20, 2022, 4:19 am CET
 *
 * @property string $title
 * @property string $description
 */
class Terms extends Model
{

    use HasFactory;

    public $table = 'terms';
    



    public $fillable = [
        'title',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string|max:50',
        'description' => 'required|string|max:255'
    ];

    
}
