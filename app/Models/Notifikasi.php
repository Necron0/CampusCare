<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_id',
        'type',
        'judul',
        'pesan',
        'link',
        'data',
        'dibaca',
        'dibaca_pada',
    ];

    protected $casts = [
        'data' => 'array',
        'dibaca' => 'boolean',
        'dibaca_pada' => 'datetime',
    ];

    // Relationships
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    // Scopes
    public function scopeBelumDibaca($query)
    {
        return $query->where('dibaca', false);
    }

    public function scopeSudahDibaca($query)
    {
        return $query->where('dibaca', true);
    }

    // Helper Methods
    public function markAsRead()
    {
        $this->update([
            'dibaca' => true,
            'dibaca_pada' => now(),
        ]);
    }

    public function getIcon()
    {
        $icons = [
            'pesanan_baru' => 'shopping-cart',
            'pertanyaan_obat' => 'question-circle',
            'pesanan_dibatalkan' => 'times-circle',
            'review_baru' => 'star',
            'stok_rendah' => 'exclamation-triangle',
            'promosi_berakhir' => 'clock',
        ];

        return $icons[$this->type] ?? 'bell';
    }

    public function getColorClass()
    {
        $colors = [
            'pesanan_baru' => 'primary',
            'pertanyaan_obat' => 'info',
            'pesanan_dibatalkan' => 'danger',
            'review_baru' => 'warning',
            'stok_rendah' => 'warning',
            'promosi_berakhir' => 'secondary',
        ];

        return $colors[$this->type] ?? 'secondary';
    }
}
