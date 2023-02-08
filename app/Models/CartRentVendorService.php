<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartRentVendorService extends Model
{
    use HasFactory;
    public $table = 'cart_rent_vendor_service';


    public $fillable = [
        'cart_id',
        'rent_vendor_service_id',
        'days'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

        'cart_id'=>'integer',
        'rent_vendor_service_id'=>'integer',
        'days'=>'integer'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'cart_id' => 'required|integer',
        'rent_vendor_service_id' => 'required|integer'

    ];
}
