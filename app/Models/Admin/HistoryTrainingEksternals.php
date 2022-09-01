<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryTrainingEksternals extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employees_id',
        'institusi_penyelenggara_training_eksternal',
        'perihal_training_eksternal',
        'hari_awal_training_eksternal',
        'hari_akhir_training_eksternal',
        'tanggal_awal_training_eksternal',
        'tanggal_akhir_training_eksternal',
        'jam_training_eksternal',
        'lokasi_training_eksternal',
        'alamat_training_eksternal',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //To Table History Training Eksternals
    public function employees(){
        return $this->belongsTo(Employees::class,'employees_id','nik_karyawan');
    }
}
