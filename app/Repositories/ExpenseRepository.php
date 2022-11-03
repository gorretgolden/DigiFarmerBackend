<?php

namespace App\Repositories;

use App\Models\Expense;
use App\Repositories\BaseRepository;

/**
 * Class ExpenseRepository
 * @package App\Repositories
 * @version November 2, 2022, 7:29 am UTC
*/

class ExpenseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_id',
        'farm_id',
        'amount'
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
        return Expense::class;
    }
}
