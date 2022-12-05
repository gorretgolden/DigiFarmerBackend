<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnimalCategory
 * @package App\Models
 * @version December 1, 2022, 11:28 am UTC
 *
 * @property string $name
 */
class AnimalCategory extends Model
{


    use HasFactory;

    public $table = 'animal_categories';




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
        'name' => 'required|string'
    ];


    //an animal category has many animals
     //animal belongs to an animal category
     public function animals()
     {
         return $this->hasMany(\App\Models\Animal::class, 'animal_category_id');
     }

     //an animal belongs to a plot
     public function plot()
     {
         return $this->belongsTo(\App\Models\Plot::class, 'plot_id');
     }


}
