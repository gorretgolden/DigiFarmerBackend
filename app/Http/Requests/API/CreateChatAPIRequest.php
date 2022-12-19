<?php

namespace App\Http\Requests\API;

use App\Models\Chat;
use App\Models\User;
use InfyOm\Generator\Request\APIRequest;

class CreateChatAPIRequest extends APIRequest
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
        $userModel = get_class(new User());
        return [
            'user_id' => "required|exists:{$userModel},id",
            'name' => "nullable",
            'is_private' => 'boolean|nullable'
        ];

    }
}
