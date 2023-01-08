<?php

namespace App\Repositories;

use App\Models\Terms;
use App\Repositories\BaseRepository;

/**
 * Class TermsRepository
 * @package App\Repositories
 * @version December 20, 2022, 9:55 am CET
*/

class TermsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'description'
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
        return Terms::class;
    }
}
