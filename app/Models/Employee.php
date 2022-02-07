<?php

namespace App\Models;

use App\Scopes\DelFlagScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Presenters\EmployeePresenter;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable, EmployeePresenter;

    //protected $table = 'employees';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'email',
        'password',
        'first_name',
        'last_name',
        'gerder',
        'birthday',
        'address',
        'avatar',
        'salary',
        'position',
        'status',
        'type_of_work',
        'ins_id',
        'upd_datetime',
        'upd_id',
        'del_flag',
        'ins_datetime',
    ];

    public $timestamps = false;
    public $sortable = ['id', 'team', 'last_name', 'email'];

    protected static function booted()
    {
        static::addGlobalScope(new DelFlagScope());
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
