<?php

namespace App\Repositories;

use App\Models\RentVendorCategory;
use App\Repositories\BaseRepository;

/**
 * Class RentVendorCategoryRepository
 * @package App\Repositories
 * @version January 13, 2023, 1:52 pm CET
*/

class RentVendorCategoryRepository extends BaseRepository
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
        return RentVendorCategory::class;
    }
}
