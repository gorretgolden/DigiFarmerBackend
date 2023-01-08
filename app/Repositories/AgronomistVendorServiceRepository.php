<?php

namespace App\Repositories;

use App\Models\AgronomistVendorService;
use App\Repositories\BaseRepository;

/**
 * Class AgronomistVendorServiceRepository
 * @package App\Repositories
 * @version December 20, 2022, 8:24 am CET
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
        'charge_unit',
        'availability',
        'description',
        'zoom_details',
        'location_details',
        'image',
        'user_id',
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
