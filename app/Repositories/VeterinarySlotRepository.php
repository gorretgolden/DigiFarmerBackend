<?php

namespace App\Repositories;

use App\Models\VeterinarySlot;
use App\Repositories\BaseRepository;

/**
 * Class VeterinarySlotRepository
 * @package App\Repositories
 * @version January 23, 2023, 8:31 am CET
*/

class VeterinarySlotRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'time',
        'status',
        'veterinary_shedule_id'
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
        return VeterinarySlot::class;
    }
}
