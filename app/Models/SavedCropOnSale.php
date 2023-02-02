<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SavedCropOnSale
 * @package App\Models
 * @version January 17, 2023, 2:04 pm CET
 *
 * @property integer $crop_on_sale_id
 * @property integer $user_id
 */
class SavedCropOnSale extends Model
{

    use HasFactory;

    public $table = 'saved_crop_on_sales';




    public $fillable = [
        'crop_on_sale_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'crop_on_sale_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'crop_on_sale_id' => 'required|integer',
        'user_id' => 'nullable|integer'
    ];


    //belongs to a crop on sale
    public function crop_on_sale()
    {
       return $this->belongsTo(\App\Models\CropOnSale::class,'crop_on_sale_id');
    }

}
