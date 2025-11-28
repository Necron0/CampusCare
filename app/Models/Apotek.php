<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apotek extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_apotek',
        'alamat',
        'no_telepon',
        'latitude',
        'longitude',
        'foto_apotek',
        'rating',
        'total_pesanan',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function obats()
    {
        return $this->hasMany(Obat::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function promos()
    {
        return $this->hasMany(Promo::class);
    }
}
