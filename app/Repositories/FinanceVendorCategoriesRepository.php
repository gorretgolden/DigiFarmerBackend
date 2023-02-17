<?php

namespace App\Repositories;

use App\Models\FinanceVendorCategories;
use App\Repositories\BaseRepository;

/**
 * Class FinanceVendorCategoriesRepository
 * @package App\Repositories
 * @version February 17, 2023, 8:18 pm CET
*/

class FinanceVendorCategoriesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image'
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
        return FinanceVendorCategories::class;
    }
}
