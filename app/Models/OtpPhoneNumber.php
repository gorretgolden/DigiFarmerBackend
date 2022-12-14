<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpPhoneNumber extends Model
{
    use HasFactory;


    public $table = 'otp_phone_numbers';




    public $fillable = [
        'otp',
        'phone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'otp' => 'integer',
        'phone' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'otp' => 'required|integer',
        'phone' => 'required|string'
    ];


}
