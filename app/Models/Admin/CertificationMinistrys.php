<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificationMinistrys extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employees_id',
        'jumlah_sertifikat_kementrian',
        'nomor_sertifikat_kementrian',
        'jenis_sertifikat_kementrian',
        'masa_berlaku_sertifikat_kementrian',
        'tanggal_terbit_kementrian',
        'sampai_tanggal_kementrian',
        'lsp_kementrian',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //To Table Certification MINISTRY
    public function employees(){
        return $this->belongsTo(Employees::class,'employees_id','nik_karyawan');
    }
}
