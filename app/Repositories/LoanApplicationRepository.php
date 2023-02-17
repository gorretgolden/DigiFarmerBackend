<?php

namespace App\Repositories;

use App\Models\LoanApplication;
use App\Repositories\BaseRepository;

/**
 * Class LoanApplicationRepository
 * @package App\Repositories
 * @version February 17, 2023, 11:00 pm CET
*/

class LoanApplicationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'finance_vendor_service_id',
        'location',
        'location_details',
        'status',
        'loan_number',
        'finance_vendor_category_id',
        'gender',
        'dob',
        'age',
        'nok_name',
        'nok_email',
        'nok_phone',
        'nok_location',
        'nok_relationship',
        'employment_status',
        'loan_start_date',
        'loan_due_date',
        'document'
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
        return LoanApplication::class;
    }
}
