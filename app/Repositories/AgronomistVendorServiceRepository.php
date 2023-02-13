<?php

namespace App\Repositories;

use App\Models\AgronomistVendorService;
use App\Repositories\BaseRepository;

/**
 * Class AgronomistVendorServiceRepository
 * @package App\Repositories
 * @version February 9, 2023, 12:57 pm CET
*/

class AgronomistVendorServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'expertise',
        'charge',
        'is_verified',
        'location',
        'charge_unit',
        'availability',
        'description',
        'zoom_details',
        'user_id',
        'image',
        'vendor_category_id'
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
        return AgronomistVendorService::class;
    }
}
