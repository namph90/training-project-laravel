<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'ins_id',
        'upd_datetime',
    ];

    public function scopeDel_flag($query)
    {
        return $query->where('del_flag', 0);
    }
}
