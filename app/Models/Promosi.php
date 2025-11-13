<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promosi extends Model
{
    protected $fillable = [
        'obat_id',
        'diskon',
        'mulai',
        'berakhir',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

}
