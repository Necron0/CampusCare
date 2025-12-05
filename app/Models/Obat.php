<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obats';

    protected $fillable = [
        'mitra_id',
        'nama_obat',
        'kategori',
        'gejala',
        'deskripsi',
        'stok',
        'harga',
        'lokasi_apotek',
        'is_active',
        'gambar',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'harga' => 'integer',
        'stok' => 'integer',
    ];

    // Relationships
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function promosi()
    {
        return $this->hasOne(Promosi::class);
    }
}
