<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Status
 * @package App\Models
 * @version December 13, 2022, 1:51 am UTC
 *
 * @property string $name
 */
class Status extends Model
{


    use HasFactory;

    public $table = 'statuses';





    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string'
    ];


    //has many tasks
    public function tasks()
  {
     return $this->hasMany(\App\Models\Task::class,'status_id');
  }

}
