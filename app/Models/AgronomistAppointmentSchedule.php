<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AgronomistAppointmentSchedule
 * @package App\Models
 * @version December 20, 2022, 1:47 pm CET
 *
 * @property integer $day_id
 * @property integer $agronomist_vendor_service_id
 * @property string $start_time
 * @property string $end_time
 */
class AgronomistAppointmentSchedule extends Model
{

    use HasFactory;

    public $table = 'agronomist_appointment_schedules';
    



    public $fillable = [
        'day_id',
        'agronomist_vendor_service_id',
        'start_time',
        'end_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'day_id' => 'integer',
        'agronomist_vendor_service_id' => 'integer',
        'start_time' => 'string',
        'end_time' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'day_id' => 'required|integer',
        'agronomist_vendor_service_id' => 'required|integer',
        'start_time' => 'required',
        'end_time' => 'required'
    ];

    
}
