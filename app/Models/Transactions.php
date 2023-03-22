<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    public $table = 'transactions';

    public $fillable = [
        'user_id',
        'transaction_ref',
        'order_ref',
        'external_ref',
        'status',
        'payment_type',
        'transaction_type',
        'is_live',
        'phone_number',
        'email',
        'amount'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'phone_number' => 'required',
        'amount'  => 'required',
        'pay_type' => 'required',
        'payment_id'  => 'required',
    ];


}
