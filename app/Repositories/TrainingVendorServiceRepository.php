<?php

namespace App\Repositories;

use App\Models\TrainingVendorService;
use App\Repositories\BaseRepository;

/**
 * Class TrainingVendorServiceRepository
 * @package App\Repositories
 * @version November 28, 2022, 1:42 pm UTC
*/

class TrainingVendorServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'charge',
        'description',
        'period',
        'period_unit',
        'access',
        'starting_date',
        'ending_date',
        'starting_time',
        'ending_time',
        'zoom_details',
        'location_details',
        'vendor_category_id',
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
        return TrainingVendorService::class;
    }
}
