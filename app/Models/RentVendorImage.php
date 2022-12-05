<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class RentVendorImage
 * @package App\Models
 * @version December 3, 2022, 10:02 am UTC
 *
 * @property string $url
 * @property integer $rent_vendor_service_id
 */
class RentVendorImage extends Model
{


    use HasFactory;

    public $table = 'rent_vendor_images';


    public $fillable = [
        'url',
        'rent_vendor_service_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'url' => 'string',
        'rent_vendor_service_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'url' => 'required|string',
        'rent_vendor_service_id' => 'required|integer'
    ];

   //rent image belongs to a rent vendor service
    public function rent_vendor_service()
    {
    return $this->belongsTo(\App\Models\RentVendorService::class, 'rent_vendor_service_id');
    }

}
