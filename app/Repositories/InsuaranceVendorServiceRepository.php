<?php

namespace App\Repositories;

use App\Models\InsuaranceVendorService;
use App\Repositories\BaseRepository;

/**
 * Class InsuaranceVendorServiceRepository
 * @package App\Repositories
 * @version December 5, 2022, 8:59 pm UTC
*/

class InsuaranceVendorServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'terms',
        'description',
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
        return InsuaranceVendorService::class;
    }
}
