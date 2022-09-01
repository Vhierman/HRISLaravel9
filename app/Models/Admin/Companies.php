<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companies extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama_perusahaan',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //From Table Companies
    public function history_positions() {
        return $this->hasMany(HistoryPositions::class,'companies_id_history','id');
    }
}
