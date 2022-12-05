<?php

namespace App\Repositories;

use App\Models\RentVendorImage;
use App\Repositories\BaseRepository;

/**
 * Class RentVendorImageRepository
 * @package App\Repositories
 * @version December 3, 2022, 10:02 am UTC
*/

class RentVendorImageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'url',
        'rent_vendor_service_id'
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
        return RentVendorImage::class;
    }
}
