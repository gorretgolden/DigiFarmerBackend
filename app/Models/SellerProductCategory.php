<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SellerProductCategory
 * @package App\Models
 * @version November 4, 2022, 12:27 pm UTC
 *
 * @property string $name
 */
class SellerProductCategory extends Model
{


    use HasFactory;

    public $table = 'seller_product_categories';





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
        'name' => 'required|string|max:100'
    ];

     //a seller product category has many products
     public function products()
     {
        return $this->hasMany(\App\Models\SellerProduct::class);
     }



}
