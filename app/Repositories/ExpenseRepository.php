<?php

namespace App\Repositories;

use App\Models\Expense;
use App\Repositories\BaseRepository;

/**
 * Class ExpenseRepository
 * @package App\Repositories
 * @version November 12, 2022, 7:34 am UTC
*/

class ExpenseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'amount',
        'expense_category_id',
        'plot_id'
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
