<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    protected $attributes = [
        'role' => UserRole::CLIENT,  // wartość domyślna
    ];

    public function getRoleAttribute($value)
    {
        return $value;
    }

    public function isOrganizer()
    {
        return $this->role === 'organizer';
    }

    public function setRoleAttribute($value)
    {
        $this->attributes['role'] = $value;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
//    public function assignRole($role)
//    {
//        $this->roles()->attach($role);
//    }
//
//    public function revokeRole($role)
//    {
//        $this->roles()->detach($role);
//    }
//
//    public function hasRole($role)
//    {
//        return $this->roles()->where('name', $role)->exists();
//    }

//    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
//    {
//        return $this->belongsToMany(Role::class);
//    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
