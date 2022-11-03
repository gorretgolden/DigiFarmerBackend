<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Crop
 * @package App\Models
 * @version November 3, 2022, 7:20 pm UTC
 *
 * @property string $name
 * @property integer $standard_price
 * @property string $image
 * @property integer $sub_category_id
 */
class Crop extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'crops';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'standard_price',
        'image',
        'sub_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'standard_price' => 'integer',
        'image' => 'string',
        'sub_category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100',
        'standard_price' => 'required|integer',
        'image' => 'nullable',
        'sub_category_id' => 'required'
    ];

    
}
