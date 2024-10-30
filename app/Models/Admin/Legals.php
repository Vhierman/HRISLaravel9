<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Legals extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama_perijinan',
        'nomor_perijinan',
        'instansi_penerbit',
        'tanggal_berlaku',
        'tanggal_habis',
        'masa_berlaku',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];
}
