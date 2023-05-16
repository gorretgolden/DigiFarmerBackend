<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\order;
use App\Models\CartPivot;

class OrderDetail extends Model
{
    use HasFactory;

    public function orders()
    {
        return $this->belongsTo(order::class);
    }

    public function cart()
    {
        return $this->belongsTo(CartPivot::class, 'cart_pivot_id');
    }
}
