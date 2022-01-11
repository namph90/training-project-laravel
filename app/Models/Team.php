<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\AncientScope;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'ins_id',
        'upd_datetime',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AncientScope());
//        static::addGlobalScope('ancient', function ($builder) {
//            return $builder->where('del_flag', '=', 0);
//        });
    }

//    public function scopeActive($query)
//    {
//        return $query->where('ins_id', 1);
//    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
