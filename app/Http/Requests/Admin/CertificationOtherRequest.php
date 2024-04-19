<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CertificationOtherRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'employees_id'          => 'required',
            'nomor_sertifikat_lain' => 'required',
            'jenis_sertifikat_lain' => 'required',
            'tanggal_terbit_lain'   => 'required|date',
            'input_oleh'            => 'required'
        ];
    }
}