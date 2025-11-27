<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obats';

    protected $fillable = [
        'nama','kategori','gejala','deskripsi','stok','harga','lokasi_apotek','is_active'
    ];
}


