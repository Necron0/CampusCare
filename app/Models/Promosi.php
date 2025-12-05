<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promosi extends Model
{
    use HasFactory;

    protected $fillable = [
        'obat_id',
        'nama_promosi',
        'deskripsi',
        'diskon',
        'mulai',
        'berakhir',
        'aktif',
    ];

    protected $casts = [
        'mulai' => 'date',
        'berakhir' => 'date',
        'diskon' => 'integer',
        'aktif' => 'boolean',
    ];

    // ===== RELATIONSHIPS =====

    /**
     * Relasi ke Obat
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    // ===== HELPER METHODS =====

    /**
     * Cek apakah promosi aktif saat ini
     * (status aktif = true DAN masih dalam periode)
     */
    public function isActive()
    {
        $today = now()->toDateString();
        return $this->aktif && $today >= $this->mulai && $today <= $this->berakhir;
    }

    /**
     * Cek apakah promosi sudah expired/kadaluarsa
     */
    public function isExpired()
    {
        return Carbon::parse($this->berakhir)->isPast();
    }

    /**
     * Hitung harga setelah diskon
     * @return float
     */
    public function getHargaDiskon()
    {
        $hargaAsli = $this->obat->harga;
        return $hargaAsli - ($hargaAsli * $this->diskon / 100);
    }

    /**
     * Hitung total hemat dari diskon
     * @return float
     */
    public function getHemat()
    {
        return $this->obat->harga - $this->getHargaDiskon();
    }

    /**
     * Get status text untuk display
     * @return string
     */
    public function getStatusText()
    {
        if ($this->isExpired()) {
            return 'Expired';
        }

        if ($this->aktif) {
            return 'Aktif';
        }

        return 'Nonaktif';
    }

    /**
     * Get badge color berdasarkan status
     * @return string
     */
    public function getStatusBadgeClass()
    {
        if ($this->isExpired()) {
            return 'danger';
        }

        if ($this->aktif) {
            return 'success';
        }

        return 'secondary';
    }
}
