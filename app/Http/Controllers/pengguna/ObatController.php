<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        // Buat query builder
        $query = Obat::with('mitra')->where('stok', '>', 0);

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan search (opsional)
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_obat', 'ILIKE', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'ILIKE', '%' . $request->search . '%')
                  ->orWhere('gejala', 'ILIKE', '%' . $request->search . '%');
            });
        }

        // Execute query dengan pagination
        $obats = $query->latest()->paginate(12);

        // Append query parameters ke pagination links
        $obats->appends($request->all());

        return view('pengguna.obat.index', compact('obats'));
    }

    public function show($id)
    {
        $obat = Obat::with('mitra')->findOrFail($id);
        return view('pengguna.obat.show', compact('obat'));
    }

    public function pesan($id)
    {
        $obat = Obat::with('mitra')->findOrFail($id);

        // Cek stok
        if ($obat->stok <= 0) {
            return redirect()->back()->with('error', 'Maaf, obat ini sedang habis.');
        }

        return view('pengguna.obat.pesan', compact('obat'));
    }

    public function pesanStore(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'qty' => 'required|integer|min:1',
            'alamat' => 'required|string|max:500',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Cari obat
        $obat = Obat::with('mitra')->findOrFail($id);

        // Cek stok
        if ($obat->stok < $validated['qty']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $obat->stok);
        }

        try {
            DB::beginTransaction();

            // Ambil data user
            $user = Auth::user();

            // Hitung total
            $subtotal = $obat->harga * $validated['qty'];
            $ongkir = 5000; // Ongkir default, bisa disesuaikan
            $totalHarga = $subtotal + $ongkir;

            // Buat order
            $order = Order::create([
                'user_id' => Auth::id(),
                'mitra_id' => $obat->mitra_id,
                'nama_penerima' => $user->name,
                'no_hp' => $user->no_hp ?? '08123456789', // Sesuaikan dengan field user
                'alamat_pengiriman' => $validated['alamat'],
                'opsi_pengiriman' => 'delivery',
                'ongkir' => $ongkir,
                'total_harga' => $totalHarga,
                'status' => 'pending',
                'catatan' => $validated['catatan'],
            ]);

            // Buat order item
            OrderItem::create([
                'order_id' => $order->id,
                'obat_id' => $obat->id,
                'qty' => $validated['qty'],
                'price' => $obat->harga,
                'subtotal' => $subtotal,
            ]);

            // Kurangi stok obat
            $obat->decrement('stok', $validated['qty']);

            DB::commit();

            return redirect()->route('pengguna.dashboard')
                ->with('success', 'Pesanan berhasil dibuat! Order ID: #' . $order->id);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
