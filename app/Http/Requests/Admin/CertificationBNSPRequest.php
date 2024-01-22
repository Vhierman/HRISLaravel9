<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CertificationBNSPRequest extends FormRequest
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
            'employees_id'                  => 'required',
            'nomor_sertifikat_bnsp'         => 'required',
            'jenis_sertifikat_bnsp'         => 'required',
            'masa_berlaku_sertifikat_bnsp'  => 'required',
            'tanggal_terbit_bnsp'           => 'required|date',
            'sampai_tanggal_bnsp'           => 'required|date',
            'lsp_bnsp'                      => 'required',
            'input_oleh'                    => 'required'
        ];
    }
}
