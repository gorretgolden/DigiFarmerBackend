<?php

namespace App\Repositories;

use App\Models\AgronomistVendorService.json;
use App\Repositories\BaseRepository;

/**
 * Class AgronomistVendorService.jsonRepository
 * @package App\Repositories
 * @version January 22, 2023, 2:11 pm CET
*/

class AgronomistVendorService.jsonRepository extends BaseRepository
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
        'location',
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
        return AgronomistVendorService.json::class;
    }
}
