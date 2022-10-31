<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class District
 * @package App\Models
 * @version October 31, 2022, 7:54 am UTC
 *
 * @property string $name
 * @property integer $country_id
 */
class District extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'districts';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'country_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'country_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'country_id' => 'nullable'
    ];

    
}
