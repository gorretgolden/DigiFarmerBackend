<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class District
 * @package App\Models
 * @version February 9, 2023, 5:19 pm CET
 *
 * @property string $name
 * @property integer $region_id
 * @property boolean $is_active
 */
class District extends Model
{

    use HasFactory;

    public $table = 'districts';




    public $fillable = [
        'name',
        'region_id',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'region_id' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|unique:districts,name',
        'region_id' => 'required|integer',
        'is_active' => 'nullable'
    ];

    public function region()
    {
        return $this->belongsTo(\App\Models\Region::class,'region_id');
    }


    //has many addresses
    public function addresses()
    {
        return $this->hasMany(\App\Models\Address::class,'address_id');
    }


}
