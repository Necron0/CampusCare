<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Obat;
use App\Models\Konsultasi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan variabel ada dan memiliki nilai default
        $totalObat = Obat::count();
        $totalKonsultasi = Konsultasi::where('user_id', $user->id)->count();
        $totalOrder = Order::where('user_id', $user->id)->count();

        // Ambil data orders dengan pengecekan
        $orders = Order::where('user_id', $user->id)
            ->with('items.obat')
            ->latest()
            ->limit(5)
            ->get();

        // Format data orders untuk view
        $formattedOrders = [];
        if ($orders) {
            foreach ($orders as $order) {
                foreach ($order->items as $item) {
                    $formattedOrders[] = [
                        'nama' => $item->obat->nama ?? 'Obat tidak ditemukan',
                        'qty' => $item->qty,
                        'total' => $item->subtotal,
                        'waktu' => $order->created_at->format('d M Y, H:i'),
                    ];
                }
            }
        }

        return view('pengguna.dashboard', compact(
            'user',
            'totalObat',
            'totalKonsultasi',
            'totalOrder',
            'formattedOrders' // Gunakan variabel yang sudah diformat
        ));
    }
}
