<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mitra_id',
        'kategori',
        'topik',
        'keluhan',
        'gejala_tambahan',
        'riwayat_alergi',
        'urgensi',
        'jawaban',
        'dokter',
        'rekomendasi_obat',
        'status',
        'dijawab_pada',
        'catatan',
    ];

    protected $casts = [
        'status' => 'string',
        'urgensi' => 'string',
        'dijawab_pada' => 'datetime',
    ];

    // ===== RELATIONSHIPS =====

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    // ===== SCOPES =====

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    // ===== HELPER METHODS =====

    public function getStatusBadgeClass()
    {
        return [
            'menunggu' => 'warning',
            'diproses' => 'info',
            'selesai' => 'success',
            'dibatalkan' => 'danger',
        ][$this->status] ?? 'secondary';
    }

    public function getUrgensiColor()
    {
        return [
            'rendah' => 'success',
            'sedang' => 'warning',
            'tinggi' => 'danger',
        ][$this->urgensi] ?? 'secondary';
    }

    public function isSelesai()
    {
        return $this->status === 'selesai';
    }

    public function isDiproses()
    {
        return $this->status === 'diproses';
    }
}
