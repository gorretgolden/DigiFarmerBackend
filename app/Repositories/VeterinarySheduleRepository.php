<?php

namespace App\Repositories;

use App\Models\VeterinaryShedule;
use App\Repositories\BaseRepository;

/**
 * Class VeterinarySheduleRepository
 * @package App\Repositories
 * @version January 23, 2023, 9:01 am CET
*/

class VeterinarySheduleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'starting_time',
        'ending_time',
        'day_id',
        'veterinary_id',
        'time_interval'
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
        return VeterinaryShedule::class;
    }
}
