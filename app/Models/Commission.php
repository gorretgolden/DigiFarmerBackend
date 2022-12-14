<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Commission
 * @package App\Models
 * @version December 12, 2022, 7:12 am UTC
 *
 * @property integer $amount
 * @property string $unit
 */
class Commission extends Model
{


    use HasFactory;

    public $table = 'commissions';




    public $fillable = [
        'amount',
        'unit'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'integer',
        'unit' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'amount' => 'required|integer',
        'unit' => 'nullable'
    ];


}
