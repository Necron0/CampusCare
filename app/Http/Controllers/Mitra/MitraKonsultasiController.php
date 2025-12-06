<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraKonsultasiController extends Controller
{
    /**
     * Tampilkan daftar konsultasi untuk mitra
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan user adalah mitra dan punya data mitra
        if (!$user->mitra) {
            return redirect()->route('mitra.profile.create')
                ->with('warning', 'Silakan lengkapi profil mitra terlebih dahulu.');
        }

        $mitraId = $user->mitra->id;

        // Dapatkan semua konsultasi yang ditujukan ke mitra ini
        $konsultasis = Konsultasi::with('user')
            ->where(function($query) use ($mitraId) {
                // Konsultasi yang khusus ditujukan ke mitra ini
                $query->where('mitra_id', $mitraId)
                      // Atau konsultasi umum yang belum diambil mitra
                      ->orWhereNull('mitra_id');
            })
            ->whereIn('status', ['menunggu', 'diproses'])
            ->orderBy('urgensi', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Hitung statistik
        $totalMenunggu = Konsultasi::where('status', 'menunggu')
            ->where(function($query) use ($mitraId) {
                $query->where('mitra_id', $mitraId)
                      ->orWhereNull('mitra_id');
            })
            ->count();

        $totalDiproses = Konsultasi::where('status', 'diproses')
            ->where('mitra_id', $mitraId)
            ->count();

        $totalSelesai = Konsultasi::where('status', 'selesai')
            ->where('mitra_id', $mitraId)
            ->count();

        return view('mitra.konsultasi.index', compact(
            'konsultasis',
            'totalMenunggu',
            'totalDiproses',
            'totalSelesai'
        ));
    }

    /**
     * Ambil konsultasi (claim)
     */
    public function claim($id)
    {
        $user = Auth::user();
        $mitraId = $user->mitra->id;

        $konsultasi = Konsultasi::findOrFail($id);

        // Cek apakah konsultasi sudah diambil
        if ($konsultasi->mitra_id && $konsultasi->mitra_id != $mitraId) {
            return redirect()->route('mitra.konsultasi.index')
                ->with('error', 'Konsultasi ini sudah diambil oleh mitra lain.');
        }

        // Ambil konsultasi
        $konsultasi->update([
            'mitra_id' => $mitraId,
            'status' => 'diproses'
        ]);

        return redirect()->route('mitra.konsultasi.index')
            ->with('success', 'Konsultasi berhasil diambil!');
    }

    /**
     * Tampilkan detail konsultasi
     */
    public function show($id)
    {
        $user = Auth::user();
        $mitraId = $user->mitra->id;

        $konsultasi = Konsultasi::with('user')
            ->where('id', $id)
            ->where(function($query) use ($mitraId) {
                $query->where('mitra_id', $mitraId)
                      ->orWhereNull('mitra_id');
            })
            ->firstOrFail();

        return view('mitra.konsultasi.show', compact('konsultasi'));
    }

    /**
     * Form jawab konsultasi
     */
    public function jawabForm($id)
    {
        $user = Auth::user();
        $mitraId = $user->mitra->id;

        $konsultasi = Konsultasi::where('id', $id)
            ->where('mitra_id', $mitraId)
            ->where('status', 'diproses')
            ->firstOrFail();

        return view('mitra.konsultasi.jawab', compact('konsultasi'));
    }

    /**
     * Proses jawaban konsultasi
     */
    public function jawab(Request $request, $id)
    {
        $request->validate([
            'jawaban' => 'required|string|min:10',
            'rekomendasi_obat' => 'nullable|string',
            'dokter' => 'nullable|string|max:255'
        ]);

        $user = Auth::user();
        $mitraId = $user->mitra->id;

        $konsultasi = Konsultasi::where('id', $id)
            ->where('mitra_id', $mitraId)
            ->where('status', 'diproses')
            ->firstOrFail();

        $konsultasi->update([
            'jawaban' => $request->jawaban,
            'rekomendasi_obat' => $request->rekomendasi_obat,
            'dokter' => $request->dokter ?? $user->mitra->nama_apotek,
            'status' => 'selesai',
            'dijawab_pada' => now()
        ]);

        return redirect()->route('mitra.konsultasi.show', $konsultasi->id)
            ->with('success', 'Jawaban berhasil dikirim!');
    }

    /**
     * Lepaskan konsultasi (jika tidak bisa ditangani)
     */
    public function release($id)
    {
        $user = Auth::user();
        $mitraId = $user->mitra->id;

        $konsultasi = Konsultasi::where('id', $id)
            ->where('mitra_id', $mitraId)
            ->where('status', 'diproses')
            ->firstOrFail();

        $konsultasi->update([
            'mitra_id' => null,
            'status' => 'menunggu',
            'jawaban' => null,
            'rekomendasi_obat' => null,
            'dokter' => null
        ]);

        return redirect()->route('mitra.konsultasi.index')
            ->with('info', 'Konsultasi berhasil dilepaskan.');
    }

    /**
     * Konsultasi yang sudah selesai
     */
    public function selesai()
    {
        $user = Auth::user();
        $mitraId = $user->mitra->id;

        $konsultasis = Konsultasi::with('user')
            ->where('mitra_id', $mitraId)
            ->where('status', 'selesai')
            ->orderBy('dijawab_pada', 'desc')
            ->paginate(10);

        return view('mitra.konsultasi.selesai', compact('konsultasis'));
    }
}
