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

    public function messages()
    {
        return [
            'company_name.required' => 'Nama perusahaan diperlukan',
            'company_name.max' => 'Jumlah karakter nama perusahaan tidak boleh melebihi 100 karakter.',
            'contact_person.required' => 'Nama penanggung jawab diperlukan',
            'contact_person.max' => 'Jumlah karakter nama penanggung jawab tidak boleh melebihi 100 karakter.',
            'email.required' => 'Email diperlukan',
            'email.max' => 'Jumlah karakter email tidak boleh melebihi 200 karakter.',
            'email.email' => 'Masukkan email yang valid.',
            'phone_number.required' => 'Nomor handphone diperlukan',
            'phone_number.max' => 'Jumlah karakter nomor handphone tidak boleh melebihi 20 karakter.',
            'position.required' => 'Jabatan diperlukan',
            'position.max' => 'Jumlah karakter jabatan tidak boleh melebihi 100 karakter.',
            'npwp.required' => 'NPWP diperlukan',
            'npwp.max' => 'Jumlah karakter NPWP tidak boleh melebihi 16 karakter.',
            'npwp.unique' => 'NPWP telah terdaftar.',
            'qualification.required' => 'Kualifikasi diperlukan',
            'qualification.max' => 'Jumlah karakter kualifikasi tidak boleh melebihi 100 karakter.',
            'province_id.required' => 'Provinsi dan Kabupaten/Kota diperlukan',
        ];
    }
}
