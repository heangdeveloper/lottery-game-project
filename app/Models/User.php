<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'referral',
        'name',
        'username',
        'password',
        'phone_number',
        'profile_photo_path',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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

    public function roles() {
        return $this->belongsToMany('App\Models\Role');
    }

    public function withdraws() {
        return $this->hasMany('App\Models\Withdraw');
    }

    public function banks() {
        return $this->hasMany('App\Models\Bank');
    }

    public function topups() {
        return $this->hasMany('App\Models\TopUp');
    }

    public function isAdminOrSuperAdmin() {
        return $this->hasAnyRole(['admin', 'superAdmin']);
    }

    public function isMember() {
        return $this->hasAnyRole(['member']);
    }

    public function hasAnyRole($roles) {
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }
        return null;
    }

    public function hasRole($role) {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return null;
    }
}
