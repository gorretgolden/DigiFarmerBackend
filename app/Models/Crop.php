<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Crop
 * @package App\Models
 * @version October 31, 2022, 8:52 am UTC
 *
 * @property string $name
 * @property integer $farm_id
 * @property integer $category_id
 * @property string $image
 */
class Crop extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'crops';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'farm_id',
        'category_id',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'farm_id' => 'integer',
        'category_id' => 'integer',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'farm_id' => 'required',
        'category_id' => 'required',
        'image' => 'nullable'
    ];

    
}
