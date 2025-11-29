<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',
        'avatar',
        'role',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function mitra()
    {
        return $this->hasOne(Mitra::class);
    }
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }
    public function konsultasis()
    {
        return $this->hasMany(Konsultasi::class);
    }
}
