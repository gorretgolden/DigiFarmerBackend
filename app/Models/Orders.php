<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\orderDetail;
use App\Models\User;

class Orders extends Model
{
    use HasFactory;


    public function orderDetails()
    {
        return $this->hasMany(orderDetail::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
