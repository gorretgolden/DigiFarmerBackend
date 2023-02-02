<?php

namespace App\Repositories;

use App\Models\RentVendorService;
use App\Repositories\BaseRepository;

/**
 * Class RentVendorServiceRepository
 * @package App\Repositories
 * @version January 12, 2023, 12:15 pm CET
*/

class RentVendorServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'rent_vendor_sub_category_id',
        'charge',
        'charge_unit',
        'total_charge',
        'description',
        'location',
        'quantity',
        'charge_day',
        'charge_frequency',
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
        return RentVendorService::class;
    }
}
