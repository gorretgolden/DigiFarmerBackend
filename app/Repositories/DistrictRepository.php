<?php

namespace App\Repositories;

use App\Models\District;
use App\Repositories\BaseRepository;

/**
 * Class DistrictRepository
 * @package App\Repositories
 * @version December 23, 2022, 9:33 am CET
*/

class DistrictRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'region_id'
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
        return District::class;
    }
}
