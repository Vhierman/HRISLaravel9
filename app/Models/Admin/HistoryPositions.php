<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryPositions extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employees_id',
        'companies_id_history',
        'areas_id_history',
        'divisions_id_history',
        'positions_id_history',
        'tanggal_mutasi',
        'file_surat_mutasi',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    public function employees(){
        return $this->belongsTo(Employees::class,'employees_id','nik_karyawan');
    }
    public function companies(){
        return $this->belongsTo(Companies::class,'companies_id_history','id');
    }
    public function areas(){
        return $this->belongsTo(Areas::class,'areas_id_history','id');
    }
    public function divisions(){
        return $this->belongsTo(Divisions::class,'divisions_id_history','id');
    }
    public function positions(){
        return $this->belongsTo(Positions::class,'positions_id_history','id');
    }
}
