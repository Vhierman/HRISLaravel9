<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MinimalSalaries extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'minimal_upah'
    ];

    protected $hidden =[
        
    ];

    
}
