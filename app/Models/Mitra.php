<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_apotek',
        'alamat',
        'telepon',
        'rating',
        'aktif',
    ];

    protected $casts = [
        'rating' => 'float',
        'aktif' => 'boolean',
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

    public function promosis()
    {
        return $this->hasMany(Promosi::class);
    }

   public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }
}
