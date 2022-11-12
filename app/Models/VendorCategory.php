<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VendorCategory
 * @package App\Models
 * @version November 9, 2022, 11:36 pm UTC
 *
 * @property string $name
 */
class VendorCategory extends Model
{


    use HasFactory;

    public $table = 'vendor_categories';


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
        'name' => 'required|max:100'
    ];


}
