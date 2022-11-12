<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Task
 * @package App\Models
 * @version November 12, 2022, 10:29 am UTC
 *
 * @property string $name
 * @property integer $plot_id
 */
class Task extends Model
{


    use HasFactory;

    public $table = 'tasks';





    public $fillable = [
        'name',
        'plot_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'plot_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'plot_id' => 'required|integer'
    ];


}
