<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Konsultasi;
class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalMitra = User::where('role', 'mitra')->count();
        $totalMahasiswa = User::where('role', 'pengguna')->count();
        $totalTransaksi = Order::count();

        $totalKonsultasi = class_exists('App\Models\Konsultasi')
            ? \App\Models\Konsultasi::count()
            : 0;
        return view('admin.dashboard', compact(
            'user',
            'totalUsers',
            'totalAdmins',
            'totalMitra',
            'totalMahasiswa',
            'totalTransaksi',
            'totalKonsultasi'
        ));
    }
}
