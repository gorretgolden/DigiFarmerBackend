<?php

namespace App\Repositories;

use App\Models\Veterinary;
use App\Repositories\BaseRepository;

/**
 * Class VeterinaryRepository
 * @package App\Repositories
 * @version January 23, 2023, 8:59 am CET
*/

class VeterinaryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'expertise',
        'charge',
        'location',
        'charge_unit',
        'availability',
        'description',
        'zoom_details',
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
        return Veterinary::class;
    }
}
