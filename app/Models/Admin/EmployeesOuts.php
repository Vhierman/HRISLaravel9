<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeesOuts extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employees_id',
        'companies_id',
        'golongans_id',
        'areas_id',
        'divisions_id',
        'positions_id',
        'nama_karyawan_keluar',
        'nomor_npwp_karyawan_keluar',
        'email_karyawan_keluar',
        'nomor_handphone_karyawan_keluar',
        'tempat_lahir_karyawan_keluar',
        'tanggal_lahir_karyawan_keluar',
        'nomor_bpjsketenagakerjaan_karyawan_keluar',
        'nomor_bpjskesehatan_karyawan_keluar',
        'nomor_rekening_karyawan_keluar',
        'pendidikan_terakhir_karyawan_keluar',
        'jenis_kelamin_karyawan_keluar',
        'agama_karyawan_keluar',
        'alamat_karyawan_keluar',
        'rt_karyawan_keluar',
        'rw_karyawan_keluar',
        'kelurahan_karyawan_keluar',
        'kecamatan_karyawan_keluar',
        'kota_karyawan_keluar',
        'provinsi_karyawan_keluar',
        'kode_pos_karyawan_keluar',
        'nomor_absen_karyawan_keluar',
        'golongan_darah_karyawan_keluar',
        'nomor_kartu_keluarga_karyawan_keluar',
        'status_nikah_karyawan_keluar',
        'nama_ayah_karyawan_keluar',
        'nama_ibu_karyawan_keluar',
        'tanggal_masuk_karyawan_keluar',
        'tanggal_keluar_karyawan_keluar',
        'status_kerja_karyawan_keluar',
        'keterangan_keluar',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];
    public function companies() {
        return $this->belongsTo(Companies::class,'companies_id','id');
    }
    public function golongans() {
        return $this->belongsTo(Golongans::class,'golongans_id','id');
    }
    public function divisions() {
        return $this->belongsTo(Divisions::class,'divisions_id','id');
    }
    public function positions() {
        return $this->belongsTo(Positions::class,'positions_id','id');
    }
    public function areas() {
        return $this->belongsTo(Areas::class,'areas_id','id');
    }
}
