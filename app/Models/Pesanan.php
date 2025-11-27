<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'user_id',
        'mitra_id',
        'total',
        'status',
        'alamat_pengantaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function pesananDetails()
    {
        return $this->hasMany(PesananDetail::class);
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class);
    }
}
