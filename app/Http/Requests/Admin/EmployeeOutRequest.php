<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeOutRequest extends FormRequest
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
            //
            'employees_id'                              => 'required|integer|min:16',
            // 'companies_id'                          => 'required|integer|exists:companies,id',
            // 'areas_id'                              => 'required|integer|exists:working_hours,id',
            // 'divisions_id'                           => 'required|integer|exists:divisions,id',
            // 'positions_id'                          => 'required|integer|exists:positions,id',
            // 'nama_karyawan_keluar'                  => 'required|string',
            // 'nomor_npwp_karyawan_keluar'            => 'required',
            // 'email_karyawan_keluar'                 => 'required|email',
            // 'nomor_handphone_karyawan_keluar'       => 'required',
            // 'tempat_lahir_karyawan_keluar'          => 'required',
            // 'tanggal_lahir_karyawan_keluar'         => 'required|date',
            // 'nomor_jht_karyawan_keluar'             => 'required|min:11',
            // 'nomor_jp_karyawan_keluar'              => 'required|min:11',
            // 'nomor_jkn_karyawan_keluar'             => 'required|min:13',
            // 'nomor_rekening_karyawan_keluar'        => 'required',
            // 'pendidikan_terakhir_karyawan_keluar'   => 'required|in:SD,SMP,SMA/SMK,D1,D2,D3,S1,S2,S3',
            // 'jenis_kelamin_karyawan_keluar'         => 'required|string|in:Pria,Wanita',
            // 'agama_karyawan_keluar'                 => 'required|string|in:Islam,Kristen Protestan,Kristen Katholik,Hindu,Budha,Konghucu',
            // 'alamat_karyawan_keluar'                => 'required',
            // 'rt_karyawan_keluar'                    => 'required|min:3',
            // 'rw_karyawan_keluar'                    => 'required|min:3',
            // 'kelurahan_karyawan_keluar'             => 'required',
            // 'kecamatan_karyawan_keluar'             => 'required',
            // 'kota_karyawan_keluar'                  => 'required',
            // 'provinsi_karyawan_keluar'              => 'required',
            // 'kode_pos_karyawan_keluar'              => 'required|min:5',
            // 'nomor_absen_karyawan_keluar'           => 'required',
            // 'golongan_darah_karyawan_keluar'        => 'required|string|in:A,B,AB,O',
            // 'nomor_kartu_keluarga_karyawan_keluar'  => 'required|min:16',
            // 'status_nikah_karyawan_keluar'          => 'required|string|in:Single,Menikah,Janda,Duda',
            // 'nama_ayah_karyawan_keluar'             => 'required|string',
            // 'nama_ibu_karyawan_keluar'              => 'required|string',
            // 'tanggal_masuk_karyawan_keluar'         => 'required|date',
            'tanggal_keluar_karyawan_keluar'            => 'required|date',
            // 'status_kerja_karyawan_keluar'          => 'required|string|in:PKWT,PKWTT,Harian,Outsourcing',
            'keterangan_keluar'                         => 'required'
        ];
    }
}
