<?php

namespace App\Repositories;

use App\Models\SellerProductCategory;
use App\Repositories\BaseRepository;

/**
 * Class SellerProductCategoryRepository
 * @package App\Repositories
 * @version November 4, 2022, 12:27 pm UTC
*/

class SellerProductCategoryRepository extends BaseRepository
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
        return SellerProductCategory::class;
    }
}
