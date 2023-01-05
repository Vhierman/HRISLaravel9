<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendancesPkls extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'students_id',
        'tanggal_absen',
        'keterangan_absen',
        'lama_absen',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //To Table Attendances
    public function students(){
        return $this->belongsTo(Students::class,'students_id','nis_siswa');
    }
}
