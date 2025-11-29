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

    // Relationships
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

    public function konsultasis()
    {
        return $this->hasMany(Konsultasi::class);
    }

    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }
}
