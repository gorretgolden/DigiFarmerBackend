<?php

namespace App\Repositories;

use App\Models\AgronomistAppointmentSchedule;
use App\Repositories\BaseRepository;

/**
 * Class AgronomistAppointmentScheduleRepository
 * @package App\Repositories
 * @version December 20, 2022, 1:47 pm CET
*/

class AgronomistAppointmentScheduleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'day_id',
        'agronomist_vendor_service_id',
        'start_time',
        'end_time'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AgronomistAppointmentSchedule::class;
    }
}
