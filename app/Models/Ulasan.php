<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $fillable = [
        'pesanan_id',
        'user_id',
        'mitra_id',
        'rating',
        'komentar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
        public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
