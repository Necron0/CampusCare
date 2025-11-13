<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_id',
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'foto',
    ];
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
}
