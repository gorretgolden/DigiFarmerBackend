<?php

namespace App\Repositories;

use App\Models\AgronomistSlot;
use App\Repositories\BaseRepository;

/**
 * Class AgronomistSlotRepository
 * @package App\Repositories
 * @version December 21, 2022, 8:50 am CET
*/

class AgronomistSlotRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'agronomist_shedule_id',
        'start_time',
        'end_time',
        'status'
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
        return AgronomistSlot::class;
    }
}
