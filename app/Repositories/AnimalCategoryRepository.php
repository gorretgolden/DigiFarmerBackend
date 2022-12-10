<?php

namespace App\Repositories;

use App\Models\AnimalCategory;
use App\Repositories\BaseRepository;

/**
 * Class AnimalCategoryRepository
 * @package App\Repositories
 * @version December 8, 2022, 12:21 pm UTC
*/

class AnimalCategoryRepository extends BaseRepository
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
        return AnimalCategory::class;
    }
}
