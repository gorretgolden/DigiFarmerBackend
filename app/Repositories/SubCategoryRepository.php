<?php

namespace App\Repositories;

use App\Models\SubCategory;
use App\Repositories\BaseRepository;

/**
 * Class SubCategoryRepository
 * @package App\Repositories
 * @version April 21, 2023, 11:52 am CEST
*/

class SubCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'is_active',
        'category_id',
        'animal_category_id'
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
        return SubCategory::class;
    }
}
