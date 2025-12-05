<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create($obat_id)
    {
        $obat = Obat::with('mitra')->findOrFail($obat_id);

        return view('pengguna.order.create', compact('obat'));
    }

    public function store(Request $request, $obat_id)
{
    $request->validate([
        'nama_penerima' => 'required|string|max:255',
        'no_hp' => 'required|string|max:20',
        'alamat' => 'required|string',
        'opsi_pengiriman' => 'required|in:delivery,pickup',
        'qty' => 'nullable|integer|min:1',
    ]);

    $obat = Obat::findOrFail($obat_id);
    $qty = $request->qty ?? 1;

    // Hitung biaya
    $price = $obat->harga;
    $subtotal = $price * $qty;
    $ongkir = $request->opsi_pengiriman === 'delivery' ? 10000 : 0;
    $total_harga = $subtotal + $ongkir;

    DB::transaction(function () use ($request, $obat, $qty, $price, $subtotal, $ongkir, $total_harga) {
        // Buat order
        $order = Order::create([
            'user_id' => Auth::id(),
            'mitra_id' => $obat->mitra_id,
            'nama_penerima' => $request->nama_penerima,
            'no_hp' => $request->no_hp,
            'alamat_pengiriman' => $request->alamat,
            'opsi_pengiriman' => $request->opsi_pengiriman,
            'ongkir' => $ongkir,
            'total_harga' => $total_harga,
            'status' => 'diproses',
            'catatan' => $request->catatan,
        ]);

        // Buat order item
        OrderItem::create([
            'order_id' => $order->id,
            'obat_id' => $obat->id,
            'qty' => $qty,
            'price' => $price,
            'subtotal' => $subtotal,
        ]);

        // Update stok
        $obat->decrement('stok', $qty);
    });

    return redirect()->route('pengguna.riwayat.index')
        ->with('success', 'Pesanan berhasil dibuat!');
}
}
