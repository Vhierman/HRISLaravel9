<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'schools_id'                => 'required',
            'divisions_id'              => 'required',
            'tanggal_masuk_pkl'         => 'required|date',
            'tanggal_selesai_pkl'       => 'required|date',
            'nis_siswa'                 => 'required',
            'nama_siswa'                => 'required|string',
            'tempat_lahir_siswa'        => 'required',
            'tanggal_lahir_siswa'       => 'required|date',
            'jenis_kelamin_siswa'       => 'required',
            'agama_siswa'               => 'required',
            'no_handphone_siswa'        => 'required',
            'jurusan'                   => 'required',
            'alamat_siswa'              => 'required',
            'rt_siswa'                  => 'required|min:3',
            'rw_siswa'                  => 'required|min:3',
            'kelurahan_siswa'           => 'required',
            'kecamatan_siswa'           => 'required',
            'kota_siswa'                => 'required',
            'provinsi_siswa'            => 'required',
            'kode_pos_siswa'            => 'required'
        ];
    }
}
