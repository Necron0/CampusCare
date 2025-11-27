<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create($obat_id)
    {
        $obat = Obat::findOrFail($obat_id);
        return view('pengguna.order.create', compact('obat'));
    }

    public function store(Request $request, $obat_id)
    {
        $request->validate([
            'nama_penerima' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'opsi_pengiriman' => 'required',
            'qty' => 'required|integer|min:1'
        ]);

        $obat = Obat::findOrFail($obat_id);

        if ($request->qty > $obat->stok) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        $ongkir = match($request->opsi_pengiriman) {
            'instant' => 15000,
            'reguler' => 8000,
            'pickup'  => 0,
            default   => 8000
        };

        DB::transaction(function() use ($request, $obat, $ongkir) {
            $subtotal = $request->qty * $obat->harga;
            $total = $subtotal + $ongkir;

            $order = Order::create([
                'nama_penerima' => $request->nama_penerima,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'opsi_pengiriman' => $request->opsi_pengiriman,
                'ongkir' => $ongkir,
                'total_harga' => $total,
                'status' => 'diproses',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'obat_id' => $obat->id,
                'qty' => $request->qty,
                'price' => $obat->harga,
                'subtotal' => $subtotal,
            ]);

            $obat->update([
                'stok' => $obat->stok - $request->qty
            ]);
        });

        return redirect()->route('pengguna.riwayat.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function riwayat()
    {
        $orders = Order::with('items.obat')->latest()->get();
        return view('pengguna.riwayat.index', compact('orders'));
    }
}



