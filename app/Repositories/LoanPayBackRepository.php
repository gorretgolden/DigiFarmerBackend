<?php

namespace App\Repositories;

use App\Models\LoanPayBack;
use App\Repositories\BaseRepository;

/**
 * Class LoanPayBackRepository
 * @package App\Repositories
 * @version December 15, 2022, 10:58 am UTC
*/

class LoanPayBackRepository extends BaseRepository
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
        return LoanPayBack::class;
    }
}
