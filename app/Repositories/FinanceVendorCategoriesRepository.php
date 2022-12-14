<?php

namespace App\Repositories;

use App\Models\FinanceVendorCategories;
use App\Repositories\BaseRepository;

/**
 * Class FinanceVendorCategoriesRepository
 * @package App\Repositories
 * @version December 14, 2022, 4:00 am UTC
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
