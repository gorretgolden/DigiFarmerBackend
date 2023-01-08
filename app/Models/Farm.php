<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Farm
 * @package App\Models
 * @version December 23, 2022, 12:49 pm CET
 *
 * @property string $name
 * @property string $owner
 * @property integer $field_area
 * @property string $size_unit
 * @property integer $address_id
 */
class Farm extends Model
{

    use HasFactory;

    public $table = 'farms';




    public $fillable = [
        'name',
        'owner',
        'field_area',
        'size_unit',
        'address_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'owner' => 'string',
        'field_area' => 'integer',
        'size_unit' => 'string',
        'address_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:20',
        'owner' => 'required|string',
        'field_area' => 'required|integer',
        'size_unit' => 'required|string',
        'address_id' => 'integer'
    ];


    //belongs to an address
    public function address()
    {
       return $this->belongsTo(\App\Models\Address::class,'address_id');
    }


    //has many plots
    public function plots()
    {
       return $this->hasMany(\App\Models\Plot::class,'farm_id');
    }


}
