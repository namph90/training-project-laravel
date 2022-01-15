<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\AncientScope;
use Kyslik\ColumnSortable\Sortable;

class Team extends Model
{
    use HasFactory, Sortable;
    protected $fillable = [
        'name',
        'ins_id',
        'upd_datetime',
        'upd_id',
        'del_flag',
        'ins_datetime',
    ];

    public $timestamps = false;
    public $sortable = ['id', 'name'];

    protected static function booted()
    {
        static::addGlobalScope(new AncientScope());
    }

    public function scopeSearch_name($query, $searchName)
    {
        return $query->where('name','like', '%'.$searchName.'%');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
