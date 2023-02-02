<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VeterinaryShedule
 * @package App\Models
 * @version January 23, 2023, 8:29 am CET
 *
 * @property string $time
 * @property integer $status
 * @property integer $veterinary_shedule_id
 */
class VeterinaryShedule extends Model
{

    use HasFactory;

    public $table = 'veterinary_shedules';




    public $fillable = [
        'date',
        'starting_time',
        'ending_time',
        'time_interval',
        'veterinary_id'
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
        'veterinary_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date' => 'required|string',
        'starting_time' => 'required|before:ending_time',
        'ending_time' => 'required|after:starting_time',
        'time_interval'=>'required|integer|min:20|max:40',
        'veterinary_id' => 'required|integer',

    ];

    // bellongs to a vet service
    public function vet_service()
    {
        return $this->belongsTo(\App\Models\Vendor::class, 'veterinary_id');
    }


     //belongs to a day
     public function day()
     {
         return $this->belongsTo(\App\Models\Day::class, 'day_id');
     }

       //has may slots
    public function slots()
    {
        return $this->hasMany(\App\Models\VeterinarySlot::class, 'veterinary_shedule_id');
    }


}
