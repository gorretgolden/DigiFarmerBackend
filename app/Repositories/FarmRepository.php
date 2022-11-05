<?php

namespace App\Repositories;

use App\Models\Farm;
use App\Repositories\BaseRepository;

/**
 * Class FarmRepository
 * @package App\Repositories
 * @version November 4, 2022, 1:52 pm UTC
*/

class FarmRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'field_area',
        'image',
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
