<?php

namespace App\Repositories;

use App\Models\TrainingVendorService;
use App\Repositories\BaseRepository;

/**
 * Class TrainingVendorServiceRepository
 * @package App\Repositories
 * @version February 8, 2023, 10:12 pm CET
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
        'image',
        'access',
        'is_verified',
        'starting_date',
        'ending_date',
        'starting_time',
        'ending_time',
        'zoom_details',
        'location',
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
