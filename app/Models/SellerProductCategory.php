<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SellerProductCategory
 * @package App\Models
 * @version January 6, 2023, 9:28 am CET
 *
 * @property string $name
 * @property string $image
 */
class SellerProductCategory extends Model
{

    use HasFactory;

    public $table = 'seller_product_categories';
    public $dir = 'storage/seller_product_categories/';




    public $fillable = [
        'name',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:20|unique:seller_product_categories',
        'image' => 'required|image'
    ];

    public function getImageAttribute($image)
    {

        if ($image) {
            return $this->dir.$image;
         }

    }


}
