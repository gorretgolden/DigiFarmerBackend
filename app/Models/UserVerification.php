<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UserVerification
 * @package App\Models
 * @version December 14, 2022, 8:49 am UTC
 *
 * @property string $image
 * @property integer $user_id
 */
class UserVerification extends Model
{

    use HasFactory;

    public $table = 'user_verifications';




    public $fillable = [
        'image',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'image' => 'required',
        'image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        'image' => 'max:3',
        'user_id' => 'required|integer'
    ];


    //verification belongs to a user
    public function user()
    {
    return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
