<?php

namespace App\Repositories;

use App\Models\ExpenseCategory;
use App\Repositories\BaseRepository;

/**
 * Class ExpenseCategoryRepository
 * @package App\Repositories
 * @version November 4, 2022, 12:51 pm UTC
*/

class ExpenseCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'standard_value',
        'description'
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
        return ExpenseCategory::class;
    }
}
