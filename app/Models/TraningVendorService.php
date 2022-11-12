<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TraningVendorService
 * @package App\Models
 * @version November 9, 2022, 11:50 pm UTC
 *
 * @property string $name
 * @property integer $charge
 * @property string $description
 * @property integer $vendor_category_id
 * @property integer $user_id
 * @property string $slots
 */
class TraningVendorService extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'traning_vendor_services';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'charge',
        'description',
        'vendor_category_id',
        'user_id',
        'slots'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'charge' => 'integer',
        'description' => 'string',
        'vendor_category_id' => 'integer',
        'user_id' => 'integer',
        'slots' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:100',
        'charge' => 'required|integer',
        'description' => 'required',
        'vendor_category_id' => 'required|integer',
        'user_id' => 'required|integer',
        'slots' => 'required'
    ];

    
}
