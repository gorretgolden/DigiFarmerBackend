<?php

namespace App\Repositories;

use App\Models\Farm;
use App\Repositories\BaseRepository;

/**
 * Class FarmRepository
 * @package App\Repositories
 * @version October 31, 2022, 8:22 am UTC
*/

class FarmRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'district_id',
        'address',
        'latitude',
        'longitude',
        'field_area',
        'user_id'
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
