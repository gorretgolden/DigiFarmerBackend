<?php

namespace App\Http\Requests\API;

use App\Models\ExpenseCategory;
use InfyOm\Generator\Request\APIRequest;

class UpdateExpenseCategoryAPIRequest extends APIRequest
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
        $rules = ExpenseCategory::$rules;
        $rules['name'] = $rules['name'].",".$this->route("expense_category");
        return $rules;
    }
}
