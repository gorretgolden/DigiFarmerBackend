<?php

namespace App\Repositories;

use App\Models\AgronomistShedule;
use App\Repositories\BaseRepository;

/**
 * Class AgronomistSheduleRepository
 * @package App\Repositories
 * @version January 22, 2023, 12:41 pm CET
*/

class AgronomistSheduleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'day_id',
        'starting_time',
        'ending_time',
        'time_interval',
        'agronomist_vendor_service_id'
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
        return AgronomistShedule::class;
    }
}
