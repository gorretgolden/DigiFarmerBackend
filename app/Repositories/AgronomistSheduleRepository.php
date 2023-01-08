<?php

namespace App\Repositories;

use App\Models\AgronomistShedule;
use App\Repositories\BaseRepository;

/**
 * Class AgronomistSheduleRepository
 * @package App\Repositories
 * @version December 21, 2022, 9:15 am CET
*/

class AgronomistSheduleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'day_id',
        'start_time',
        'end_time',
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
