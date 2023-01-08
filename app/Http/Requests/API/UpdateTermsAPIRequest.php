<?php

namespace App\Http\Requests\API;

use App\Models\Terms;
use InfyOm\Generator\Request\APIRequest;

class UpdateTermsAPIRequest extends APIRequest
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
        $rules = Terms::$rules;
        
        return $rules;
    }
}
