<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Task
 * @package App\Models
 * @version November 18, 2022, 2:44 am UTC
 *
 * @property string $name
 * @property string $reminder_date
 * @property integer $plot_id
 */
class Task extends Model
{


    use HasFactory;

    public $table = 'tasks';





    public $fillable = [
        'name',
        'reminder_date',
        'plot_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'reminder_date' => 'string',
        'plot_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'reminder_date' => 'required|string',
        'plot_id' => 'required|integer'
    ];

    //a task belongs to plot
  public function plot()
  {
     return $this->belongsTo(\App\Models\Plot::class,'plot_id');
  }

}
