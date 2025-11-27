<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id','obat_id','qty','price','subtotal'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}



