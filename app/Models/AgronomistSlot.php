<?php

namespace App\Models;

use Eloquent as Model;
use DateTime;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AgronomistSlot
 * @package App\Models
 * @version December 21, 2022, 8:50 am CET
 *
 * @property integer $agronomist_shedule_id
 * @property string $start_time
 * @property string $end_time
 * @property string $status
 */
class AgronomistSlot extends Model
{

    use HasFactory;

    public $table = 'agronomist_slots';




    public $fillable = [
        'agronomist_shedule_id',
        'time',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'agronomist_shedule_id' => 'integer',
        'time' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'agronomist_shedule_id' => 'required|integer',
        'time' => 'required|string',
        'status' => 'nullable'
    ];


    //belongs to an agronomist schedule
    public function agronomist_schedule()
    {
        return $this->hasMany(\App\Models\AgronomistShedule::class, 'agronomist_shedule_id');
    }


}
