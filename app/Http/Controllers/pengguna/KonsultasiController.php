<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiController extends Controller
{
    /**
     * Tampilkan daftar konsultasi user
     */
    public function index()
    {
        $user = Auth::user();

        $konsultasis = Konsultasi::where('user_id', $user->id)
            ->with('mitra')
            ->latest()
            ->get();

        // Statistik
        $totalKonsultasi = $konsultasis->count();
        $konsultasiAktif = $konsultasis->whereIn('status', ['menunggu', 'diproses'])->count();
        $konsultasiSelesai = $konsultasis->where('status', 'selesai')->count();

        return view('pengguna.konsultasi.index', compact(
            'konsultasis',
            'totalKonsultasi',
            'konsultasiAktif',
            'konsultasiSelesai'
        ));
    }

    /**
     * Form konsultasi baru
     */
    public function create()
    {
        $mitras = \App\Models\Mitra::where('aktif', true)
            ->orderBy('nama_apotek', 'asc')
            ->get(['id', 'nama_apotek', 'alamat']);

        return view('pengguna.konsultasi.create', compact('mitras'));
    }

    /**
     * Simpan konsultasi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'nullable|string|max:100',
            'topik' => 'required|string|max:200',
            'keluhan' => 'required|string',
            'gejala_tambahan' => 'nullable|string',
            'riwayat_alergi' => 'nullable|string|max:255',
            'urgensi' => 'nullable|in:rendah,sedang,tinggi',
        ]);

        Konsultasi::create([
            'user_id' => Auth::id(),
            'kategori' => $request->kategori,
            'topik' => $request->topik,
            'keluhan' => $request->keluhan,
            'gejala_tambahan' => $request->gejala_tambahan,
            'riwayat_alergi' => $request->riwayat_alergi,
            'urgensi' => $request->urgensi ?? 'rendah',
            'status' => 'menunggu',
        ]);

        return redirect()->route('pengguna.konsultasi.index')
            ->with('success', 'Konsultasi berhasil dikirim! Tunggu jawaban dari tenaga medis.');
    }

    /**
     * Tampilkan detail konsultasi
     */
    public function show($id)
    {
        $konsultasi = Konsultasi::where('user_id', Auth::id())
            ->with('mitra')
            ->findOrFail($id);

        return view('pengguna.konsultasi.show', compact('konsultasi'));
    }

    /**
     * Batalkan konsultasi
     */
    public function cancel($id)
    {
        $konsultasi = Konsultasi::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($konsultasi->status != 'menunggu') {
            return back()->withErrors(['error' => 'Hanya konsultasi yang menunggu yang bisa dibatalkan.']);
        }

        $konsultasi->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Konsultasi berhasil dibatalkan.');
    }
}
