<?php

namespace App\Repositories;

use App\Models\Plot;
use App\Repositories\BaseRepository;

/**
 * Class PlotRepository
 * @package App\Repositories
 * @version October 31, 2022, 11:00 am UTC
*/

class PlotRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'crop_id',
        'size',
        'latitude',
        'longitude'
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
