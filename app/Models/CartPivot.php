<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VendorService;

class CartPivot extends Model
{
    use HasFactory;

    public $table = "cart_pivots";

    public $fillable = [
        "cart_id",
        "vendor_service_id",
        "quantity",
        "type",
        "total_cost",
        "user_id",
    ];

    public function product()
    {
        return $this->belongsTo(VendorService::class, "vendor_service_id");
    }
}
