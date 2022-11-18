<?php

namespace App\Repositories;

use App\Models\CropHarvest;
use App\Repositories\BaseRepository;

/**
 * Class CropHarvestRepository
 * @package App\Repositories
 * @version November 18, 2022, 2:13 am UTC
*/

class CropHarvestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'plot_id',
        'quantity',
        'quantity_unit'
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
