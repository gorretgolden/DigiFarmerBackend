<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use URL;
use Storage;
/**
 * Class Crop
 * @package App\Models
 * @version November 4, 2022, 12:16 pm UTC
 *
 * @property string $name
 * @property integer $standard_price
 * @property integer $sub_category_id
 * @property string $image
 */
class Crop extends Model
{


    use HasFactory;

    public $table = 'crops';

    public $dir = 'storage/crops/';



    public $fillable = [
        'name',
        'standard_price',
        'category_id',
        'image',
        'price_unit'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'standard_price' => 'integer',
        'category_id' => 'integer',
        'image' => 'string',
        'price_unit'=>'string'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100',
        'standard_price' => 'required',
        'category_id' => 'required|integer',
        'image' => 'nullable',
        'price_unit'=>'required|string'
    ];



       //a crop has many crops on sale
       public function crops_on_sale()
       {
          return $this->hasMany(\App\Models\CropOnSale::class,'crop_id');
       }

     //a crop belongs to category
     public function category()
     {
         return $this->belongsTo(\App\Models\Category::class, 'category_id');
     }


     //a crop has one plot
      public function plot()
        {
           return $this->hasOne(\App\Models\Plot::class);
        }

       //a crop belongs to many buyers
       public function buyers()
       {
          return $this->belongsToMany(\App\Models\CropBuyer::class);
       }


       public function getImageAttribute($value)
       {


        return $this->dir.$value;
       }

}
