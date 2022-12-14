<?php

namespace App\Repositories;

use App\Models\PeriodUnit;
use App\Repositories\BaseRepository;

/**
 * Class PeriodUnitRepository
 * @package App\Repositories
 * @version December 14, 2022, 4:28 am UTC
*/

class PeriodUnitRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
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
        return PeriodUnit::class;
    }
}
