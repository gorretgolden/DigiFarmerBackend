<?php

namespace App\Repositories;

use App\Models\Trial;
use App\Repositories\BaseRepository;

/**
 * Class TrialRepository
 * @package App\Repositories
 * @version November 15, 2022, 11:31 am UTC
*/

class TrialRepository extends BaseRepository
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
        return Trial::class;
    }
}
