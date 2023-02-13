<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Region
 * @package App\Models
 * @version February 9, 2023, 4:47 pm CET
 *
 * @property string $name
 * @property boolean $is_active
 */
class Region extends Model
{

    use HasFactory;

    public $table = 'regions';




    public $fillable = [
        'name',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'is_active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'is_active' => 'nullable'
    ];


    public function districts()
    {
        return $this->hasMany(\App\Models\District::class,'region_id');
    }

}
