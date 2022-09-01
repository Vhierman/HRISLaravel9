<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryMotorcycles extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employees_id',
        'merk_motor',
        'type_motor',
        'nomor_polisi',
        'warna_motor',
        'nomor_rangka_motor',
        'nomor_mesin_motor',
        'tanggal_akhir_pajak_motor',
        'tanggal_akhir_plat_motor',
        'tanggal_penyerahan_motor',
        'foto_stnk_motor',
        'foto_motor',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //To Table Inventory Motorcycles
    public function employees(){
        return $this->belongsTo(Employees::class,'employees_id','nik_karyawan');
    }
}
