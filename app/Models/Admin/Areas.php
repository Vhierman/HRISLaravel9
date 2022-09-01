<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Areas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'area',
        'input_oleh',
        'edit_oleh',
        'hapus_oleh'
    ];

    protected $hidden =[
        
    ];

    //From Table Areas
    public function history_positions() {
        return $this->hasMany(HistoryPositions::class,'areas_id_history','id');
    }
}
