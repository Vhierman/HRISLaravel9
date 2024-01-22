<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QccInternals extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employees_id',
        'nama_group_qcc_internal',
        'tema_qcc_internal',
        'circle_leader_qcc_internal',
        'tanggal_konvensi_qcc_internal',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //To Table QCC Internal
    public function employees(){
        return $this->belongsTo(Employees::class,'employees_id','nik_karyawan');
    }
}
