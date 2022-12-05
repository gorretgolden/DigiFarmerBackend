<?php

namespace App\Repositories;

use App\Models\AnimalCategory;
use App\Repositories\BaseRepository;

/**
 * Class AnimalCategoryRepository
 * @package App\Repositories
 * @version December 1, 2022, 11:28 am UTC
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
