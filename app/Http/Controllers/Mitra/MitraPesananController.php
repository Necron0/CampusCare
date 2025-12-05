<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraPesananController extends Controller
{
    /**
     * Tampilkan daftar pesanan
     */
    public function index(Request $request)
    {
        $mitra = Auth::user()->mitra;

        // Query pesanan
        $query = $mitra->orders()
            ->with(['user', 'orderItems.obat'])
            ->latest();

        // Filter by status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Pagination
        $pesanans = $query->paginate(10)->withQueryString();

        // Hitung statistik
        $totalPesanan = $mitra->orders()->count();
        $pesananPending = $mitra->orders()->where('status', 'pending')->count();
        $pesananDiproses = $mitra->orders()->where('status', 'diproses')->count();
        $pesananDikirim = $mitra->orders()->where('status', 'dikirim')->count();

        return view('mitra.pesanan.index', compact(
            'pesanans',
            'totalPesanan',
            'pesananPending',
            'pesananDiproses',
            'pesananDikirim'
        ));
    }

    /**
     * Tampilkan detail pesanan
     */
    public function show($id)
    {
        $mitra = Auth::user()->mitra;

        // Ambil pesanan milik mitra ini
        $pesanan = $mitra->orders()
            ->with(['user', 'orderItems.obat'])
            ->findOrFail($id);

        return view('mitra.pesanan.show', compact('pesanan'));
    }

    /**
     * Update status pesanan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan'
        ]);

        $mitra = Auth::user()->mitra;
        $pesanan = $mitra->orders()->findOrFail($id);

        // Validasi status flow
        $allowedTransitions = [
            'pending' => ['diproses', 'dibatalkan'],
            'diproses' => ['dikirim', 'dibatalkan'],
            'dikirim' => ['selesai'],
            'selesai' => [],
            'dibatalkan' => []
        ];

        $currentStatus = $pesanan->status;
        $newStatus = $request->status;

        // Cek apakah transisi diperbolehkan
        if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return back()->withErrors(['status' => 'Perubahan status tidak valid.']);
        }

        // Update status
        $pesanan->update(['status' => $newStatus]);

        // Pesan berdasarkan status
        $messages = [
            'diproses' => 'Pesanan berhasil diproses!',
            'dikirim' => 'Pesanan berhasil dikirim!',
            'selesai' => 'Pesanan berhasil diselesaikan!',
            'dibatalkan' => 'Pesanan telah dibatalkan.'
        ];

        return back()->with('success', $messages[$newStatus] ?? 'Status pesanan berhasil diupdate!');
    }

    /**
     * Konfirmasi pesanan diterima (oleh pelanggan)
     */
    public function konfirmasiDiterima($id)
    {
        $mitra = Auth::user()->mitra;
        $pesanan = $mitra->orders()->findOrFail($id);

        // Hanya pesanan dengan status 'dikirim' yang bisa dikonfirmasi
        if ($pesanan->status !== 'dikirim') {
            return back()->withErrors(['error' => 'Hanya pesanan yang sedang dikirim yang bisa dikonfirmasi.']);
        }

        $pesanan->update(['status' => 'selesai']);

        return back()->with('success', 'Pesanan berhasil dikonfirmasi sebagai diterima!');
    }

    /**
     * Batalkan pesanan
     */
    public function batalkan(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:500'
        ]);

        $mitra = Auth::user()->mitra;
        $pesanan = $mitra->orders()->findOrFail($id);

        // Hanya pesanan pending atau diproses yang bisa dibatalkan
        if (!in_array($pesanan->status, ['pending', 'diproses'])) {
            return back()->withErrors(['error' => 'Pesanan tidak dapat dibatalkan.']);
        }

        $pesanan->update([
            'status' => 'dibatalkan',
            'catatan' => 'Dibatalkan oleh mitra: ' . $request->alasan
        ]);

        // TODO: Kembalikan stok obat
        foreach ($pesanan->orderItems as $item) {
            $item->obat->increment('stok', $item->jumlah);
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
    }
}
