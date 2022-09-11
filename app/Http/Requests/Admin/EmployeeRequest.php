<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'companies_id'                  => 'required|integer|exists:companies,id',
            'working_hours_id'              => 'required|integer|exists:working_hours,id',
            'divisions_id'                  => 'required|integer|exists:divisions,id',
            'positions_id'                  => 'required|integer|exists:positions,id',
            'golongans_id'                  => 'required|integer|exists:golongans,id',
            'areas_id'                      => 'required|integer|exists:areas,id',
            'nik_karyawan'                  => 'required|integer|min:16',
            'nama_karyawan'                 => 'required|string',
            'email_karyawan'                => 'required|email',
            'nomor_absen'                   => 'required',
            // 'nomor_npwp'                 => 'required|integer|min:15',
            'nomor_handphone'               => 'required',
            'tempat_lahir'                  => 'required',
            'tanggal_lahir'                 => 'required|date',
            'agama'                         => 'required|string|in:Islam,Kristen Protestan,Kristen Katholik,Hindu,Budha,Konghucu',
            'jenis_kelamin'                 => 'required|string|in:Pria,Wanita',
            'pendidikan_terakhir'           => 'required|in:SD,SMP,SMA/SMK,D1,D2,D3,S1,S2,S3',
            'golongan_darah'                => 'required|string|in:A,B,AB,O',
            'alamat'                        => 'required',
            'rt'                            => 'required|min:3',
            'rw'                            => 'required|min:3',
            'kelurahan'                     => 'required',
            'kecamatan'                     => 'required',
            'kota'                          => 'required',
            'provinsi'                      => 'required',
            'kode_pos'                      => 'required|integer|min:5',
            // 'foto_karyawan'              => 'required|image',
            // 'foto_ktp'                   => 'required|image',
            // 'foto_npwp'                  => 'required|image',
            // 'foto_kk'                    => 'required|image',
            // 'nomor_bpjskesehatan'        => 'required|integer|min:13',
            // 'nomor_bpjsketenagakerjaan'  => 'required|integer|min:11',
            'nomor_kartu_keluarga'          => 'required|integer|min:16',
            'status_nikah'                  => 'required|string|in:Single,Menikah,Janda,Duda',
            'nama_ibu'                      => 'required|string',
            'nama_ayah'                     => 'required|string',
            'tanggal_mulai_kerja'           => 'required|date',
            'tanggal_akhir_kerja'           => 'required|date',
            'status_kerja'                  => 'required|string|in:PKWT,PKWTT,Harian,Outsourcing',
            'nama_bank'                     => 'required',
            'nomor_rekening'                => 'required|integer'
            // 'gaji_pokok'                 => 'required',
            // 'uang_makan'                 => 'required',
            // 'uang_transport'             => 'required',
            // 'tunjangan_tugas'            => 'required',
            // 'tunjangan_pulsa'            => 'required',
            // 'tunjangan_jabatan'          => 'required'
        ];
    }
}
