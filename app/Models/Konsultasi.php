<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $fillable = ['user_id', 'topik', 'hasil', 'tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
