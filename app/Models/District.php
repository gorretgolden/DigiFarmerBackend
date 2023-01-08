<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class District
 * @package App\Models
 * @version December 23, 2022, 9:33 am CET
 *
 * @property string $name
 * @property integer $region_id
 */
class District extends Model
{

    use HasFactory;

    public $table = 'districts';




    public $fillable = [
        'name',
        'region_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'region_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'region_id' => 'required|integer'
    ];

    //belongs to a region
    public function region()
    {
       return $this->belongsTo(\App\Models\Region::class,'region_id');
    }



}
