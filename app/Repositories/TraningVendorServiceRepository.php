<?php

namespace App\Repositories;

use App\Models\TraningVendorService;
use App\Repositories\BaseRepository;

/**
 * Class TraningVendorServiceRepository
 * @package App\Repositories
 * @version November 9, 2022, 11:50 pm UTC
*/

class TraningVendorServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'charge',
        'description',
        'vendor_category_id',
        'user_id',
        'slots'
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
        return TraningVendorService::class;
    }
}
