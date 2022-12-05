<?php

namespace App\Repositories;

use App\Models\RentVendorService;
use App\Repositories\BaseRepository;

/**
 * Class RentVendorServiceRepository
 * @package App\Repositories
 * @version December 3, 2022, 9:01 am UTC
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
        'description',
        'image'
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
