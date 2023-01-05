<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Students extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'schools_id',
        'divisions_id',
        'tanggal_masuk_pkl',
        'tanggal_selesai_pkl',
        'nis_siswa',
        'nama_siswa',
        'tempat_lahir_siswa',
        'tanggal_lahir_siswa',
        'jenis_kelamin_siswa',
        'agama_siswa',
        'no_handphone_siswa',
        'jurusan',
        'alamat_siswa',
        'rt_siswa',
        'rw_siswa',
        'kelurahan_siswa',
        'kecamatan_siswa',
        'kota_siswa',
        'provinsi_siswa',
        'kode_pos_siswa',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    public function divisions() {
        return $this->belongsTo(Divisions::class,'divisions_id','id');
    }

    public function schools(){
        return $this->belongsTo(Schools::class,'schools_id','id');
    }

    // From Table Karyawan
    public function attendances_pkls() {
        return $this->hasMany(AttendancesPkls::class,'students_id','id');
    }
}
