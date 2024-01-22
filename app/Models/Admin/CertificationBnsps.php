<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificationBnsps extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employees_id',
        'jumlah_sertifikat_bnsp',
        'nomor_sertifikat_bnsp',
        'jenis_sertifikat_bnsp',
        'masa_berlaku_sertifikat_bnsp',
        'tanggal_terbit_bnsp',
        'sampai_tanggal_bnsp',
        'lsp_bnsp',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //To Table Certification BNSP
    public function employees(){
        return $this->belongsTo(Employees::class,'employees_id','nik_karyawan');
    }
}
