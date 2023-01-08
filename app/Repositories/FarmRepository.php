<?php

namespace App\Repositories;

use App\Models\Farm;
use App\Repositories\BaseRepository;

/**
 * Class FarmRepository
 * @package App\Repositories
 * @version December 23, 2022, 12:49 pm CET
*/

class FarmRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'owner',
        'field_area',
        'size_unit',
        'address_id'
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
        return Farm::class;
    }
}
