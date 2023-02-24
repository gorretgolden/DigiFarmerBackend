<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_bank' => 'required',
            'account_number' => 'required',
            'amount'  => 'required',
            'narration'=>'required',
            'currency' => 'required',
            'reference'=>'required',
            'beneficiary_name' => 'required',
        ];
    }
}
