<?php

namespace App\Repositories;

use App\Models\LoanPlan;
use App\Repositories\BaseRepository;

/**
 * Class LoanPlanRepository
 * @package App\Repositories
 * @version February 17, 2023, 2:20 pm CET
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
