<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EcoCashNumberFormRequest extends Request
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
            'phone_number' => 'required|integer|between:771000000,779999999',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone_number.required' => 'EcoCash phone number is required',
            'phone_number.integer'  => 'Please enter a valid EcoCash phone number',
            'phone_number.between'  => 'Please enter a valid EcoCash phone number',
        ];
    }
}
