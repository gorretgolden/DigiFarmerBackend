<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUserType extends Model
{
    use HasFactory;

    public $table = 'user_user_type';



    public $fillable = [
        'user_id',
        'user_type_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'user_type_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|integer',
        'user_type_id' => 'required|integer'
    ];


    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function user_type(){
        return $this->belongsTo(\App\Models\UserType::class);
    }
}
