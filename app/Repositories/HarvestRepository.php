<?php

namespace App\Repositories;

use App\Models\Harvest;
use App\Repositories\BaseRepository;

/**
 * Class HarvestRepository
 * @package App\Repositories
 * @version November 2, 2022, 7:51 am UTC
*/

class HarvestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'farm_id',
        'harvest_amount'
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
        return Harvest::class;
    }
}
