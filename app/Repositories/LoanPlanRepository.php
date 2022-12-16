<?php

namespace App\Repositories;

use App\Models\LoanPlan;
use App\Repositories\BaseRepository;

/**
 * Class LoanPlanRepository
 * @package App\Repositories
 * @version December 15, 2022, 10:15 am UTC
*/

class LoanPlanRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'value',
        'period_unit'
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
        return LoanPlan::class;
    }
}
