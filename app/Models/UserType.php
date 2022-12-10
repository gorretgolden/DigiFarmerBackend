<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UserType
 * @package App\Models
 * @version December 5, 2022, 9:49 pm UTC
 *
 * @property string $name
 */
class UserType extends Model
{


    use HasFactory;

    public $table = 'user_types';




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

   //user type has many users
   public function users()
      {
          return $this->hasMany(\App\Models\User::class, 'user_type_id');
      }
}
