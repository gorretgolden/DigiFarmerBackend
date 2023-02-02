<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AgronomistShedule
 * @package App\Models
 * @version December 21, 2022, 9:15 am CET
 *
 * @property integer $day_id
 * @property string $start_time
 * @property string $end_time
 * @property integer $agronomist_vendor_service_id
 */
class AgronomistShedule extends Model
{

    use HasFactory;

    public $table = 'agronomist_shedules';




    public $fillable = [
        'date',
        'starting_time',
        'ending_time',
        'time_interval',
        'agronomist_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'string',
        'starting_time' => 'string',
        'ending_time' => 'string',
        'time_interval'=>'integer',
        'agronomist_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date' => 'required|string',
        'agronomist_id' => 'required|integer',
        'starting_time' => 'required|before:ending_time',
        'ending_time' => 'required|after:starting_time',
        'time_interval'=>'required|integer|min:20|max:40',
    ];


    //belongs to an agronomist vendor service
    public function agronomist_vendor_service()
    {
        return $this->belongsTo(\App\Models\AgronomistVendorService::class, 'agronomist_id');
    }

    //belongs to a day
    public function day()
    {
        return $this->belongsTo(\App\Models\Day::class, 'day_id');
    }

    //has may slots
    public function slots()
    {
        return $this->hasMany(\App\Models\AgronomistSlot::class, 'agronomist_shedule_id');
    }


}
