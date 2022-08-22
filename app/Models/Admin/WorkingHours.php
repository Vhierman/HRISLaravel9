<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkingHours extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'jam_masuk',
        'jam_pulang',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];
}
