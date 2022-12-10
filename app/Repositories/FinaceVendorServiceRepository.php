<?php

namespace App\Repositories;

use App\Models\FinaceVendorService;
use App\Repositories\BaseRepository;

/**
 * Class FinaceVendorServiceRepository
 * @package App\Repositories
 * @version December 7, 2022, 11:11 am UTC
*/

class FinaceVendorServiceRepository extends BaseRepository
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
        'duration_unit',
        'duration',
        'payment_frequency',
        'status',
        'simple_interest',
        'total_amount_paid_back',
        'vendor_category_id',
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
        return FinaceVendorService::class;
    }
}
