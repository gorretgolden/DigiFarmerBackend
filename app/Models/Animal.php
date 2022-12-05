<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Animal
 * @package App\Models
 * @version December 1, 2022, 11:36 am UTC
 *
 * @property integer $animal_category_id
 * @property integer $plot_id
 * @property integer $total
 */
class Animal extends Model
{


    use HasFactory;

    public $table = 'animals';


    public $fillable = [
        'animal_category_id',
        'plot_id',
        'total'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'animal_category_id' => 'integer',
        'plot_id' => 'integer',
        'total' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'animal_category_id' => 'required|integer',
        'plot_id' => 'required|integer',
        'total' => 'required|integer'
    ];

   //animal belongs to an animal category
    public function animal_category()
    {
        return $this->belongsTo(\App\Models\AnimalCategory::class, 'animal_category_id');
    }



     //animal belongs to plot
     public function plot()
     {
         return $this->belongsTo(\App\Models\Plot::class, 'plot_id');
     }

}
