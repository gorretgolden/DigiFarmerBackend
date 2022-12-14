<?php

namespace App\Repositories;

use App\Models\Commission;
use App\Repositories\BaseRepository;

/**
 * Class CommissionRepository
 * @package App\Repositories
 * @version December 12, 2022, 7:12 am UTC
*/

class CommissionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'amount',
        'unit'
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
        return Commission::class;
    }
}
