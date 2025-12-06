<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar pesanan aktif
     */
    public function index()
    {
        $userId = Auth::id(); // TAMBAHKAN INI

        $orders = Order::where('user_id', $userId)
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->with(['mitra', 'items.obat'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Order::where('user_id', $userId)
                ->whereIn('status', ['selesai', 'dibatalkan'])
                ->count(),
            'selesai' => Order::where('user_id', $userId)
                ->where('status', 'selesai')
                ->count(),
            'dibatalkan' => Order::where('user_id', $userId)
                ->where('status', 'dibatalkan')
                ->count(),
            'total_belanja' => Order::where('user_id', $userId)
                ->where('status', 'selesai')
                ->sum('total_harga') // Sesuaikan dengan nama kolom di migration
        ];

        return view('pengguna.riwayat.index', compact('orders', 'stats'));
    }

    /**
     * Tampilkan riwayat pesanan (selesai & dibatalkan)
     */
   public function riwayat()
{
    $userId = Auth::id();

    // Tampilkan SEMUA order, tidak hanya selesai/dibatalkan
    $orders = Order::where('user_id', $userId)
        // ->whereIn('status', ['selesai', 'dibatalkan']) // HAPUS ATAU COMMENT INI
        ->with(['mitra', 'items.obat'])
        ->latest()
        ->paginate(15);

    $stats = [
        'total' => Order::where('user_id', $userId)->count(), // Semua order
        'selesai' => Order::where('user_id', $userId)
            ->where('status', 'selesai')
            ->count(),
        'dibatalkan' => Order::where('user_id', $userId)
            ->where('status', 'dibatalkan')
            ->count(),
        'total_belanja' => Order::where('user_id', $userId)
            ->where('status', 'selesai')
            ->sum('total_harga'),
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

        return view('pengguna.pesanan.show', compact('order'));
    }

    // ... method lainnya tetap sama
}
