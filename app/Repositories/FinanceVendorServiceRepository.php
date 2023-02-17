<?php

namespace App\Repositories;

use App\Models\FinanceVendorService;
use App\Repositories\BaseRepository;

/**
 * Class FinanceVendorServiceRepository
 * @package App\Repositories
 * @version February 17, 2023, 3:05 pm CET
*/

class FinanceVendorServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'principal',
        'interest_rate',
        'interest_rate_unit',
        'payment_frequency_pay',
        'is_verified',
        'simple_interest',
        'total_amount_paid_back',
        'vendor_category_id',
        'user_id',
        'loan_plan_id',
        'loan_pay_back_id',
        'finance_vendor_category_id',
        'location',
        'terms',
        'payment_frequency_pay',
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
        return FinanceVendorService::class;
    }
}
