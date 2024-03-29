<?php

namespace App\Repositories;

use App\Models\FarmerTraining;
use App\Repositories\BaseRepository;

/**
 * Class FarmerTrainingRepository
 * @package App\Repositories
 * @version November 29, 2022, 3:48 am UTC
*/

class FarmerTrainingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'is_registered',
        'training_vendor_service_id',
        'user_id'
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
