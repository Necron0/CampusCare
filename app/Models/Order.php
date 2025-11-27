<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'nama_penerima','no_hp','alamat',
        'opsi_pengiriman','ongkir','total_harga','status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}





