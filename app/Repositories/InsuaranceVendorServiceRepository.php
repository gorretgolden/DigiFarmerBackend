<?php

namespace App\Repositories;

use App\Models\InsuaranceVendorService;
use App\Repositories\BaseRepository;

/**
 * Class InsuaranceVendorServiceRepository
 * @package App\Repositories
 * @version January 7, 2023, 1:41 pm CET
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
