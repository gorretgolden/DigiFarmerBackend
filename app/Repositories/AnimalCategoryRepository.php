<?php

namespace App\Repositories;

use App\Models\AnimalCategory;
use App\Repositories\BaseRepository;

/**
 * Class AnimalCategoryRepository
 * @package App\Repositories
 * @version December 14, 2022, 7:50 am UTC
*/

class AnimalCategoryRepository extends BaseRepository
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
        return AnimalCategory::class;
    }
}
