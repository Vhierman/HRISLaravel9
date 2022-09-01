<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
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
            'nama_sekolah'                  => 'required',
            'no_telepon_sekolah'            => 'required',
            'email_sekolah'                 => 'required|email',
            'nama_guru_pembimbing'          => 'required|string',
            'no_handphone_guru_pembimbing'  => 'required',
            'alamat_sekolah'                => 'required',
            'rt_sekolah'                    => 'required|min:3',
            'rw_sekolah'                    => 'required|min:3',
            'kelurahan_sekolah'             => 'required',
            'kecamatan_sekolah'             => 'required',
            'kota_sekolah'                  => 'required',
            'provinsi_sekolah'              => 'required',
            'kode_pos_sekolah'              => 'required|integer|min:3'
        ];
    }
}
