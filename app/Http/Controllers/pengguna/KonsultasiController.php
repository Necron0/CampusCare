<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;

class KonsultasiController extends Controller
{
    public function index()
    {
        $konsultasis = Konsultasi::latest()->get();
        return view('pengguna.konsultasi.index', compact('konsultasis'));
    }
}


