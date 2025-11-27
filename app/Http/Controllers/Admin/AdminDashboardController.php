<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalMitra = User::where('role', 'mitra')->count();
        $totalMahasiswa = User::where('role', 'user')->count();

        return view('admin.dashboard', compact(
            'user',
            'totalUsers',
            'totalAdmins',
            'totalMitra',
            'totalMahasiswa'

        ));
    }
}
