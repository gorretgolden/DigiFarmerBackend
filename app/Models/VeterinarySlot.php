<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VeterinarySlot
 * @package App\Models
 * @version January 23, 2023, 8:31 am CET
 *
 * @property string $time
 * @property integer $status
 * @property integer $veterinary_shedule_id
 */
class VeterinarySlot extends Model
{

    use HasFactory;

    public $table = 'veterinary_slots';




    public $fillable = [
        'time',
        'status',
        'veterinary_shedule_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'time' => 'string',
        'status' => 'integer',
        'veterinary_shedule_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'time' => 'required',
        'status' => 'nullable',
        'veterinary_shedule_id' => 'required|integer'
    ];


     //belongs to a vet schedule
     public function vet_schedule()
     {
         return $this->belongsTo(\App\Models\VeterinaryShedule::class, 'veterinary_shedule_id');
     }

}
