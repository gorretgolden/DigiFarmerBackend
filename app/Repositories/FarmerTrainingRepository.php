<?php

namespace App\Repositories;

use App\Models\FarmerTraining;
use App\Repositories\BaseRepository;

/**
 * Class FarmerTrainingRepository
 * @package App\Repositories
 * @version November 10, 2022, 12:06 am UTC
*/

class FarmerTrainingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'training_vendor_service_id',
        'starting_date',
        'ending_date',
        'access',
        'period',
        'period_unit',
        'farmer_time',
        'status'
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
        return FarmerTraining::class;
    }
}
