<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Tampilkan riwayat pesanan (semua status)
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua pesanan user
        $orders = Order::where('user_id', $userId)
            ->with(['mitra', 'items.obat'])
            ->latest()
            ->paginate(15);

        // Hitung statistik
        $stats = [
            'total' => Order::where('user_id', $userId)->count(),
            'selesai' => Order::where('user_id', $userId)
                ->where('status', 'selesai')
                ->count(),
            'dibatalkan' => Order::where('user_id', $userId)
                ->where('status', 'dibatalkan')
                ->count(),
            'total_belanja' => Order::where('user_id', $userId)
                ->where('status', 'selesai')
                ->sum('total_harga')
        ];

        return view('pengguna.riwayat.index', compact('orders', 'stats'));
    }

    /**
     * Tampilkan detail pesanan
     */
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['mitra', 'items.obat'])
            ->findOrFail($id);

        return view('pengguna.riwayat.show', compact('order'));
    }
}
