<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RegistrationsUpdateRequest extends FormRequest
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
            'company_name' => ['max:100'],
            'contact_person' => ['max: 100'],
            'email' => ['max:200', 'email'],
            'phone_number' => ['min:5', 'max:20'],
            'position' => ['max:100'],
            'company_address' => ['max:200'],
            'npwp' => ['min:15', 'max:16'],
            'qualification' => ['max:100'],
            'province_id' => [],
            'province_code' => [],
            'status' => ['max:1'],
            'membership_id' => ['nullable', 'max:200'],
            'company_type' => ['max:200']
        ];
    }

    protected function failedValidation($validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag()
        ], 400));
    }

    public function messages()
    {
        return [
            'company_name.max' => 'Jumlah karakter nama perusahaan tidak boleh melebihi 100 karakter.',
            'contact_person.max' => 'Jumlah karakter nama penanggung jawab tidak boleh melebihi 100 karakter.',
            'email.max' => 'Jumlah karakter email tidak boleh melebihi 200 karakter.',
            'email.email' => 'Masukkan email yang valid.',
            'phone_number.min' => 'Jumlah karakter nomor handphone tidak boleh kurang dari 5 karakter.',
            'phone_number.max' => 'Jumlah karakter nomor handphone tidak boleh melebihi 20 karakter.',
            'position.max' => 'Jumlah karakter jabatan tidak boleh melebihi 100 karakter.',
            'npwp.min' => 'Jumlah karakter NPWP tidak boleh kurang dari 15 karakter.',
            'npwp.max' => 'Jumlah karakter NPWP tidak boleh melebihi 16 karakter.',
            'qualification.max' => 'Jumlah karakter kualifikasi tidak boleh melebihi 100 karakter.',
            'status.max' => 'Status tidak valid.',
            'membership_id.max' => 'Karakter nomor anggota terlalu panjang.',
            'company_type.max' => 'Karakter tipe perusahaan terlalu panjang.',
        ];
    }
}
