<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mitra_id',
        'nama_penerima',
        'no_hp',
        'alamat_pengiriman',
        'opsi_pengiriman',
        'ongkir',
        'total_harga',
        'status',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class);
    }
}
