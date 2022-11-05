<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Farm
 * @package App\Models
 * @version November 4, 2022, 1:52 pm UTC
 *
 * @property string $name
 * @property string $address
 * @property number $latitude
 * @property number $longitude
 * @property number $field_area
 * @property string $image
 * @property integer $user_id
 */
class Farm extends Model
{

    use HasFactory;

    public $table = 'farms';
    



    public $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'field_area',
        'image',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
        'field_area' => 'double',
        'image' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100',
        'address' => 'required|string',
        'latitude' => 'required',
        'longitude' => 'required',
        'field_area' => 'required',
        'image' => 'nullable',
        'user_id' => 'required|integer'
    ];

    
}
