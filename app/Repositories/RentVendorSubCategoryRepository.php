<?php

namespace App\Repositories;

use App\Models\RentVendorSubCategory;
use App\Repositories\BaseRepository;

/**
 * Class RentVendorSubCategoryRepository
 * @package App\Repositories
 * @version December 3, 2022, 8:38 am UTC
*/

class RentVendorSubCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'rent_vendor_category_id'
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
        return RentVendorSubCategory::class;
    }
}
