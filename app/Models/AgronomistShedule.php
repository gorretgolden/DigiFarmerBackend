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
        'day_id',
        'start_time',
        'end_time',
        'agronomist_vendor_service_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'day_id' => 'integer',
        'start_time' => 'string',
        'end_time' => 'string',
        'agronomist_vendor_service_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'day_id' => 'required|integer',
        'agronomist_vendor_service_id' => 'required|integer',
        'time' => 'required'
    ];


    //belongs to an agronomist vendor service
    public function agronomist_vendor_service()
    {
        return $this->belongsTo(\App\Models\AgronomistVendorService::class, 'agronomist_vendor_service_id');
    }

    //belongs to a day
    public function day()
    {
        return $this->belongsTo(\App\Models\Day::class, 'day_id');
    }

    //has may slots
    public function slots()
    {
        return $this->hasMany(\App\Models\Slot::class, 'agronomist_shedule_id');
    }


}
