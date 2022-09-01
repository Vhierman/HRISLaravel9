<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schools extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama_sekolah',
        'no_telepon_sekolah',
        'email_sekolah',
        'nama_guru_pembimbing',
        'no_handphone_guru_pembimbing',
        'alamat_sekolah',
        'rt_sekolah',
        'rw_sekolah',
        'kelurahan_sekolah',
        'kecamatan_sekolah',
        'kota_sekolah',
        'provinsi_sekolah',
        'kode_pos_sekolah',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];
}
