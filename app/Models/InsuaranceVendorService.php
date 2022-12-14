<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class InsuaranceVendorService
 * @package App\Models
 * @version December 5, 2022, 8:59 pm UTC
 *
 * @property string $name
 * @property string $terms
 * @property string $description
 * @property integer $user_id
 */
class InsuaranceVendorService extends Model
{


    use HasFactory;

    public $table = 'insuarance_vendor_services';




    public $fillable = [
        'name',
        'terms',
        'description',
        'user_id',
        'vendor_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'terms' => 'string',
        'description' => 'string',
        'user_id' => 'integer',
        'vendor_category_id'=>'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'terms' => 'required|string',
        'description' => 'required|string',
        'user_id' => 'required|integer',
        'vendor_category_id' => 'required|integer'
    ];


}
