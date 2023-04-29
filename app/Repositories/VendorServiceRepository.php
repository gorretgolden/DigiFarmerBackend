<?php

namespace App\Repositories;

use App\Models\VendorService;
use App\Repositories\BaseRepository;

/**
 * Class VendorServiceRepository
 * @package App\Repositories
 * @version April 21, 2023, 11:23 pm CEST
*/

class VendorServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'price_unit',
        'price',
        'description',
        'weight_unit',
        'stock_amount',
        'is_verified',
        'expertise',
        'charge',
        'charge_frequency',
        'zoom_details',
        'location',
        'starting_date',
        'ending_date',
        'starting_time',
        'ending_time',
        'principal',
        'interest_rate',
        'interest_rate_unit',
        'payment_frequency_pay',
        'simple_interest',
        'status',
        'total_amount_paid_back',
        'document_type',
        'terms',
        'loan_pay_back',
        'access',
        'loan_plan_id',
        'sub_category_id',
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
        return VendorService::class;
    }
}
