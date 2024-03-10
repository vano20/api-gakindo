<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistrationsCreateRequest extends FormRequest
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
            'company_name' => ['required', 'max:100'],
            'contact_person' => ['required', 'max: 100'],
            'email' => ['required', 'max:200', 'email'],
            'phone_number' => ['required', 'max:20'],
            'position' => ['required', 'max:100'],
            'company_address' => ['required', 'max:200'],
            'npwp' => ['required', 'max:16'],
            'qualification' => ['required', 'max:100'],
            'province_id' => ['required']
        ];
    }

    protected function failedValidation($validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
