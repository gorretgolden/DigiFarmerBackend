<?php

namespace App\Models;

use Eloquent as Model;
use Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Contact
 * @package App\Models
 * @version December 19, 2022, 6:19 pm UTC
 *
 * @property integer $user_id
 * @property string $subject
 * @property string $message
 */
class Contact extends Model
{

    use HasFactory;

    public $table = 'contacts';




    public $fillable = [
        'user_id',
        'subject',
        'message'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'subject' => 'string',
        'message' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable|integer',
        'subject' => 'required|string|max:50',
        'message' => 'required|string|max:255'
    ];


    //Belongs to a user
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class,'user_id');
    }

    public function getCreatedAtAttribute($date)
    {
      return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($date)
   {
       return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i');
   }


}
