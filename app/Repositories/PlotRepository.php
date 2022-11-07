<?php

namespace App\Repositories;

use App\Models\Plot;
use App\Repositories\BaseRepository;

/**
 * Class PlotRepository
 * @package App\Repositories
 * @version November 7, 2022, 8:09 am UTC
*/

class PlotRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'size',
        'size_unit',
        'farm_id',
        'crop_id'
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
        return Plot::class;
    }
}
