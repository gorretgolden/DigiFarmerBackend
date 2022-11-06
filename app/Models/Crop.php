<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Crop
 * @package App\Models
 * @version November 4, 2022, 12:16 pm UTC
 *
 * @property string $name
 * @property integer $standard_price
 * @property integer $sub_category_id
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
        'standard_price',
        'sub_category_id',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'standard_price' => 'integer',
        'sub_category_id' => 'integer',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100',
        'standard_price' => 'required',
        'sub_category_id' => 'required|integer',
        'image' => 'nullable'
    ];

     //a crop belongs to a sub category
     public function sub_category()
     {
         return $this->belongsTo(\App\Models\SubCategory::class, 'sub_category_id');
     }

}
