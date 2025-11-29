<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promosi extends Model
{
    use HasFactory;

    protected $fillable = [
        'obat_id',
        'diskon',
        'mulai',
        'berakhir',
    ];

    protected $casts = [
        'mulai' => 'date',
        'berakhir' => 'date',
        'diskon' => 'integer',
    ];

    // Relationships
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    // Helper methods
    public function isActive()
    {
        $today = now()->toDateString();
        return $today >= $this->mulai && $today <= $this->berakhir;
    }
}
