<?php

namespace App\Http\Requests\API;

use App\Models\TrainingVendorService;
use InfyOm\Generator\Request\APIRequest;

class UpdateTrainingVendorServiceAPIRequest extends APIRequest
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
        $rules = TrainingVendorService::$rules;
        $rules['name'] = $rules['name'].",".$this->route("training_vendor_service");
        return $rules;
    }
}
