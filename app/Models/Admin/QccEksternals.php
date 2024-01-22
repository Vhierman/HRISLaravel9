<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QccEksternals extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employees_id',
        'nama_group_qcc_eksternal',
        'tema_qcc_eksternal',
        'circle_leader_qcc_eksternal',
        'tanggal_konvensi_qcc_eksternal',
        'instansi',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //To Table QCC Eksternal
    public function employees(){
        return $this->belongsTo(Employees::class,'employees_id','nik_karyawan');
    }
}
