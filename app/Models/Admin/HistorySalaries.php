<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistorySalaries extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employees_id',
        'gaji_pokok',
        'uang_makan',
        'uang_transport',
        'tunjangan_tugas',
        'tunjangan_pulsa',
        'tunjangan_jabatan',
        'jumlah_upah',
        'upah_lembur_perjam',
        'potongan_bpjsks_perusahaan',
        'potongan_jht_perusahaan',
        'potongan_jp_perusahaan',
        'potongan_jkm_perusahaan',
        'potongan_jkk_perusahaan',
        'jumlah_bpjstk_perusahaan',
        'potongan_bpjsks_karyawan',
        'potongan_jht_karyawan',
        'potongan_jp_karyawan',
        'jumlah_bpjstk_karyawan',
        'take_home_pay',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //To Table History Salaries
    public function employees(){
        return $this->belongsTo(Employees::class,'employees_id','nik_karyawan');
    }
}
