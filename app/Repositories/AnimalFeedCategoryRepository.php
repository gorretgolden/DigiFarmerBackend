<?php

namespace App\Repositories;

use App\Models\AnimalFeedCategory;
use App\Repositories\BaseRepository;

/**
 * Class AnimalFeedCategoryRepository
 * @package App\Repositories
 * @version November 29, 2022, 10:57 am UTC
*/

class AnimalFeedCategoryRepository extends BaseRepository
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
        return AnimalFeedCategory::class;
    }
}
