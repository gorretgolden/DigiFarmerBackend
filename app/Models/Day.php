<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Day
 * @package App\Models
 * @version December 20, 2022, 12:39 pm CET
 *
 * @property string $name
 */
class Day extends Model
{

    use HasFactory;

    public $table = 'days';




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
        'name' => 'required|string|max:15'
    ];

    //a day has many agronomist shedules
    public function agronomist_shedules()
    {
        return $this->hasMany(\App\Models\AgronomistShedule::class, 'day_id');
    }

    //has many vet schedules
     //a day has many agronomist shedules
     public function vet_shedules()
     {
         return $this->hasMany(\App\Models\VeterinaryShedule::class, 'day_id');
     }



}
