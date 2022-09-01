<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryCars extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employees_id',
        'merk_mobil',
        'type_mobil',
        'nomor_polisi',
        'warna_mobil',
        'nomor_rangka_mobil',
        'nomor_mesin_mobil',
        'tanggal_akhir_pajak_mobil',
        'tanggal_akhir_plat_mobil',
        'tanggal_penyerahan_mobil',
        'foto_stnk_mobil',
        'foto_mobil',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //To Table Inventory Cars
    public function employees(){
        return $this->belongsTo(Employees::class,'employees_id','nik_karyawan');
    }
}
