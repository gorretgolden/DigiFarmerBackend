<?php

namespace App\Repositories;

use App\Models\FarmerFinanceApplication;
use App\Repositories\BaseRepository;

/**
 * Class FarmerFinanceApplicationRepository
 * @package App\Repositories
 * @version November 22, 2022, 9:55 am UTC
*/

class FarmerFinanceApplicationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'finance_vendor_service_id',
        'user_id',
        'is_approved',
        'national_id',
        'drivin_permit',
        'land_title'
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
        return FarmerFinanceApplication::class;
    }
}
