<?php

namespace App\Models;

//use App\Scopes\AncientScope;
use App\Scopes\DelFlagScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;

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
    public $sortable = ['id', 'team','last_name', 'email'];

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

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function scopeSearch_name($query, $searchName)
    {
        return $query->where('last_name','like', '%'.$searchName.'%');
    }

    public function scopeSearch_team($query, $searchTeam)
    {
        return $query->where('team_id','=', $searchTeam);
    }

    public function scopeSearch_email($query, $searchEmail)
    {
        return $query->where('email','like', '%'.$searchEmail.'%');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
