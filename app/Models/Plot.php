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


    use HasFactory;

    public $table = 'plots';






    public $fillable = [
        'name',
        'crop_id',
        'district_id',
        'size',
        'size_unit',
        'farm_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'crop_id' => 'integer',
        'size' => 'integer',
        'size_unit' => 'string',
        'farm_id'=>'integer',
        'district_id'=>'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:plots',
        'crop_id' => 'required',
        'size' => 'required|min:1|integer',
        'size_unit' => 'required|string',
        'farm_id' => 'required',
        'district_id' => 'required'
    ];


    //a plot belongs to a district
    public function district()
    {
       return $this->belongsTo(\App\Models\District::class,'district_id');
    }

    //a plot belongs to a crop
    public function crop()
    {
       return $this->belongsTo(\App\Models\Crop::class,'crop_id');
    }

      //a plot belongs to a farm
      public function farm()
      {
         return $this->belongsTo(\App\Models\Farm::class,'farm_id');
      }


      //a plot has many expenses
      public function expenses()
      {
         return $this->hasMany(\App\Models\Expense::class,'plot_id');
      }


         //a plot has many Tasks
         public function tasks()
         {
            return $this->hasMany(\App\Models\Task::class,'plot_id');
         }


         //a plot has many crop harvests
         public function crop_harvests()
         {
            return $this->hasMany(\App\Models\CropHarvest::class,'plot_id');
         }
}
