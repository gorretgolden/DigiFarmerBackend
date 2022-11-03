<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Plot
 * @package App\Models
 * @version October 31, 2022, 11:00 am UTC
 *
 * @property string $name
 * @property integer $crop_id
 * @property number $size
 * @property number $latitude
 * @property  $longitude
 */
class Plot extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'plots';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'crop_id',
        'size',
        'latitude',
        'longitude'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'crop_id' => 'integer',
        'size' => 'double',
        'latitude' => 'double'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'crop_id' => 'required',
        'size' => 'required',
        'latitude' => 'required',
        'longitude' => 'required'
    ];

    //a plot has many crops
    public function crops()
    {
       return $this->hasMany(\App\Models\Crop::class,'plot_id');
    }

      //a plot belongs to a farm
      public function farm()
      {
         return $this->belongsTo(\App\Models\Farm::class,'farm_id');
      }


      //a plot has many expenses
      public function expenses()
      {
         return $this->hasMany(\App\Models\Expense::class,'expense_category_id');
      }
}
