<?php

namespace App\Http\Requests\API;

use App\Models\CropBuyer;
use InfyOm\Generator\Request\APIRequest;

class UpdateCropBuyerAPIRequest extends APIRequest
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
        $rules = CropBuyer::$rules;
        
        return $rules;
    }
}
