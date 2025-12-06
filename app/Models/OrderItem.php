<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'obat_id',
        'qty',
        'price',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function obat()
    {
        // withTrashed() agar obat yang sudah dihapus tetap bisa ditampilkan
        return $this->belongsTo(Obat::class)->withTrashed();
    }
}
