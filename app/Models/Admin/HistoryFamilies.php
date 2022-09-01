<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryFamilies extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employees_id',
        'hubungan_keluarga',
        'nik_history_keluarga',
        'nomor_bpjs_kesehatan_history_keluarga',
        'nama_history_keluarga',
        'jenis_kelamin_history_keluarga',
        'tempat_lahir_history_keluarga',
        'tanggal_lahir_history_keluarga',
        'golongan_darah_history_keluarga',
        'dokumen_history_keluarga',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //To Table History Families
    public function employees(){
        return $this->belongsTo(Employees::class,'employees_id','nik_karyawan');
    }
}
