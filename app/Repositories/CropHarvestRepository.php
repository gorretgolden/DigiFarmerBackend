<?php

namespace App\Repositories;

use App\Models\CropHarvest;
use App\Repositories\BaseRepository;

/**
 * Class CropHarvestRepository
 * @package App\Repositories
 * @version November 26, 2022, 6:32 pm UTC
*/

class CropHarvestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'quantity',
        'quantity_unit',
        'plot_id'
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
        return CropHarvest::class;
    }
}
