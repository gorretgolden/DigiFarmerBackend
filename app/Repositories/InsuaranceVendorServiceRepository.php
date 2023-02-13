<?php

namespace App\Repositories;

use App\Models\InsuaranceVendorService;
use App\Repositories\BaseRepository;

/**
 * Class InsuaranceVendorServiceRepository
 * @package App\Repositories
 * @version February 8, 2023, 7:46 pm CET
*/

class InsuaranceVendorServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'terms',
        'image',
        'description',
        'is_verified',
        'location',
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
        return InsuaranceVendorService::class;
    }
}
