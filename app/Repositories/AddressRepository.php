<?php

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\BaseRepository;

/**
 * Class AddressRepository
 * @package App\Repositories
 * @version December 23, 2022, 12:13 pm CET
*/

class AddressRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'country_id',
        'district_name',
        'address_name',
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
        return Address::class;
    }
}
