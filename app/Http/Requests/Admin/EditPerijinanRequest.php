<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditPerijinanRequest extends FormRequest
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
            'nama_perijinan'    => 'required',
            'nomor_perijinan'   => 'required',
            'instansi_penerbit' => 'required',
            'tanggal_berlaku'   => 'required|date',
            'tanggal_habis'     => 'required|date',
            'masa_berlaku'      => 'required',
            'edit_oleh'         => 'required'
        ];
    }
}
