<?php

namespace App\Repositories;

use App\Models\FaqCategory;
use App\Repositories\BaseRepository;

/**
 * Class FaqCategoryRepository
 * @package App\Repositories
 * @version December 20, 2022, 3:56 am CET
*/

class FaqCategoryRepository extends BaseRepository
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
        return FaqCategory::class;
    }
}
