<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OvertimeRequest extends FormRequest
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
            'tanggal_lembur'    => 'required|date',
            'keterangan_lembur' => 'required',
            'jam_masuk'         => 'required',
            'jam_istirahat'     => 'required',
            'jam_pulang'        => 'required',
            'jenis_lembur'      => 'required|string|in:Biasa,Libur'
        ];
    }
}
