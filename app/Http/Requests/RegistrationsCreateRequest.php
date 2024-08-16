<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

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
            'phone_number' => ['required', 'min:5', 'max:20'],
            'position' => ['required', 'max:100'],
            'company_address' => ['required', 'max:200'],
            'npwp' => ['required', 'min:15', 'max:16', Rule::unique('registrations', 'npwp')->where('period', date('Y'))],
            'qualification' => ['required', 'max:100'],
            'province_id' => ['required'],
            'province_code' => ['required'],
            'company_type' => ['required', 'max:200']
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
            'phone_number.min' => 'Jumlah karakter nomor handphone tidak boleh kurang dari 5 karakter.',
            'phone_number.max' => 'Jumlah karakter nomor handphone tidak boleh melebihi 20 karakter.',
            'position.required' => 'Jabatan diperlukan',
            'position.max' => 'Jumlah karakter jabatan tidak boleh melebihi 100 karakter.',
            'npwp.required' => 'NPWP diperlukan',
            'npwp.min' => 'Jumlah karakter NPWP tidak boleh kurang dari 15 karakter.',
            'npwp.max' => 'Jumlah karakter NPWP tidak boleh melebihi 16 karakter.',
            'npwp.unique' => 'NPWP telah terdaftar.',
            'qualification.required' => 'Kualifikasi diperlukan',
            'qualification.max' => 'Jumlah karakter kualifikasi tidak boleh melebihi 100 karakter.',
            'province_id.required' => 'Kabupaten/Kota diperlukan',
            'province_code.required' => 'Provinsi diperlukan',
            'company_type.required' => 'Tipe perusahaan diperlukan.',
            'company_type.max' => 'Karakter tipe perusahaan terlalu panjang.',
        ];
    }
}
