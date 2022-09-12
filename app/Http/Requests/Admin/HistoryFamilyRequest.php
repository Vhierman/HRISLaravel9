<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HistoryFamilyRequest extends FormRequest
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
            'employees_id'                          => 'required|integer',
            'hubungan_keluarga'                     => 'required|string|in:Istri,Suami,Anak,Ayah,Ibu',
            'nik_history_keluarga'                  => 'required|min:16',
            'nama_history_keluarga'                 => 'required|string',
            'jenis_kelamin_history_keluarga'        => 'required|in:Pria,Wanita',
            'tempat_lahir_history_keluarga'         => 'required',
            'tanggal_lahir_history_keluarga'        => 'required|date',
            'golongan_darah_history_keluarga'       => 'required|string|in:A,B,AB,O',
            'dokumen_history_keluarga'              => 'required|image|max:512'
        ];
    }
}
