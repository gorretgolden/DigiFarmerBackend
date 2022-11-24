<?php

namespace App\Repositories;

use App\Models\FinanceVendorService;
use App\Repositories\BaseRepository;

/**
 * Class FinanceVendorServiceRepository
 * @package App\Repositories
 * @version November 22, 2022, 9:01 am UTC
*/

class FinanceVendorServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'principal',
        'interest_rate',
        'interest_rate_unit',
        'duration',
        'duration_unit',
        'status',
        'simple_interest',
        'total_amount_paid_back',
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
        return FinanceVendorService::class;
    }
}
