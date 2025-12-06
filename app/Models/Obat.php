<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obat extends Model
{
    use HasFactory, SoftDeletes;

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

    // Untuk SoftDeletes
    protected $dates = ['deleted_at'];

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
