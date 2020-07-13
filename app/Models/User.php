<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'role_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function suggests()
    {
        return $this->hasMany(Suggest::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
