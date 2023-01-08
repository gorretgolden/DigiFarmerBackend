<?php

namespace App\Repositories;

use App\Models\Term;
use App\Repositories\BaseRepository;

/**
 * Class TermRepository
 * @package App\Repositories
 * @version December 20, 2022, 9:54 am CET
*/

class TermRepository extends BaseRepository
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
        return Term::class;
    }
}
