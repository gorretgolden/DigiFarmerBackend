<?php

namespace App\Repositories;

use App\Models\SellerProductCategory;
use App\Repositories\BaseRepository;

/**
 * Class SellerProductCategoryRepository
 * @package App\Repositories
 * @version January 6, 2023, 10:21 am CET
*/

class SellerProductCategoryRepository extends BaseRepository
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
        return SellerProductCategory::class;
    }
}
