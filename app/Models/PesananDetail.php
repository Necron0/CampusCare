<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    protected $fillable = [
        'pesanan_id',
        'obat_id',
        'jumlah',
        'harga_satuan',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
