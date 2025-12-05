<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Ambil notifikasi untuk dropdown (AJAX)
     */
    public function getNotifikasi()
    {
        $mitra = Auth::user()->mitra;

        $notifikasis = Notifikasi::where('mitra_id', $mitra->id)
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = Notifikasi::where('mitra_id', $mitra->id)
            ->belumDibaca()
            ->count();

        return response()->json([
            'notifikasis' => $notifikasis,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Halaman daftar semua notifikasi
     */
    public function index()
    {
        $mitra = Auth::user()->mitra;

        $notifikasis = Notifikasi::where('mitra_id', $mitra->id)
            ->latest()
            ->paginate(20);

        return view('mitra.notifikasi.index', compact('notifikasis'));
    }

    /**
     * Tandai notifikasi sebagai dibaca
     */
    public function markAsRead($id)
    {
        $mitra = Auth::user()->mitra;

        $notifikasi = Notifikasi::where('mitra_id', $mitra->id)
            ->findOrFail($id);

        $notifikasi->markAsRead();

        // Redirect ke link jika ada
        if ($notifikasi->link) {
            return redirect($notifikasi->link);
        }

        return back();
    }

    /**
     * Tandai semua notifikasi sebagai dibaca
     */
    public function markAllAsRead()
    {
        $mitra = Auth::user()->mitra;

        Notifikasi::where('mitra_id', $mitra->id)
            ->belumDibaca()
            ->update([
                'dibaca' => true,
                'dibaca_pada' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai sebagai dibaca'
        ]);
    }

    /**
     * Hapus notifikasi
     */
    public function destroy($id)
    {
        $mitra = Auth::user()->mitra;

        $notifikasi = Notifikasi::where('mitra_id', $mitra->id)
            ->findOrFail($id);

        $notifikasi->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus');
    }

    /**
     * Hapus semua notifikasi yang sudah dibaca
     */
    public function clearRead()
    {
        $mitra = Auth::user()->mitra;

        Notifikasi::where('mitra_id', $mitra->id)
            ->sudahDibaca()
            ->delete();

        return back()->with('success', 'Notifikasi yang sudah dibaca berhasil dihapus');
    }
}
