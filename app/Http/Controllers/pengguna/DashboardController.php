<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Konsultasi;

class DashboardController extends Controller
{
    public function index()
    {
        // tanpa login → user dummy
        $user = (object)[
            'id' => 1,
            'name' => 'Pengguna'
        ];

        $totalObat = Obat::count();
        $totalKonsultasi = Konsultasi::count();

        // Order belum ada → set 0 dulu
        $totalOrder = 0;

        return view('pengguna.dashboard', compact(
            'user','totalObat','totalKonsultasi','totalOrder'
        ));
    }
}






