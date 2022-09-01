<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Divisions extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'penempatan',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //From Table Divisions
    public function history_positions() {
        return $this->hasMany(HistoryPositions::class,'divisions_id_history','id');
    }
}
