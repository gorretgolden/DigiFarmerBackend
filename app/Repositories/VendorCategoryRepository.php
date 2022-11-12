<?php

namespace App\Repositories;

use App\Models\VendorCategory;
use App\Repositories\BaseRepository;

/**
 * Class VendorCategoryRepository
 * @package App\Repositories
 * @version November 9, 2022, 11:36 pm UTC
*/

class VendorCategoryRepository extends BaseRepository
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
        return VendorCategory::class;
    }
}
