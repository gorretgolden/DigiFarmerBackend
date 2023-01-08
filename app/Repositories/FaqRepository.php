<?php

namespace App\Repositories;

use App\Models\Faq;
use App\Repositories\BaseRepository;

/**
 * Class FaqRepository
 * @package App\Repositories
 * @version December 20, 2022, 4:03 am CET
*/

class FaqRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'faq_category_id',
        'question',
        'answer'
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
        return Faq::class;
    }
}
