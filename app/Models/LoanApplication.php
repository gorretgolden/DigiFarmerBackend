<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LoanApplication
 * @package App\Models
 * @version February 17, 2023, 11:00 pm CET
 *
 * @property integer $user_id
 * @property integer $finance_vendor_service_id
 * @property string $location
 * @property string $location_details
 * @property string $status
 * @property string $loan_number
 * @property integer $finance_vendor_category_id
 * @property string $gender
 * @property string $dob
 * @property integer $age
 * @property string $nok_name
 * @property string $nok_email
 * @property string $nok_phone
 * @property string $nok_location
 * @property string $nok_relationship
 * @property string $employment_status
 * @property string $loan_start_date
 * @property string $loan_due_date
 * @property string $document
 */
class LoanApplication extends Model
{

    use HasFactory;

    public $table = 'loan_applications';
    



    public $fillable = [
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'finance_vendor_service_id' => 'integer',
        'location' => 'string',
        'location_details' => 'string',
        'status' => 'string',
        'loan_number' => 'string',
        'finance_vendor_category_id' => 'integer',
        'gender' => 'string',
        'dob' => 'string',
        'age' => 'integer',
        'nok_name' => 'string',
        'nok_email' => 'string',
        'nok_phone' => 'string',
        'nok_location' => 'string',
        'nok_relationship' => 'string',
        'employment_status' => 'string',
        'loan_start_date' => 'string',
        'loan_due_date' => 'string',
        'document' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|integer',
        'finance_vendor_service_id' => 'required|integer',
        'location' => 'nullable',
        'location_details' => 'nullable',
        'status' => 'nullable|string',
        'loan_number' => 'nullable',
        'finance_vendor_category_id' => 'required|integer',
        'gender' => 'required|string',
        'dob' => 'required|string',
        'age' => 'nullable',
        'nok_name' => 'required|string',
        'nok_email' => 'nullable',
        'nok_phone' => 'required|integer',
        'nok_location' => 'required|string',
        'nok_relationship' => 'required|string',
        'employment_status' => 'required|string',
        'loan_start_date' => 'nullable',
        'loan_due_date' => 'nullable',
        'document' => 'required'
    ];

    
}
