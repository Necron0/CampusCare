<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Promosi;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MitraPromosiController extends Controller
{
    /**
     * Tampilkan daftar promosi
     */
    public function index(Request $request)
    {
        $mitra = Auth::user()->mitra;

        // Query promosi
        $query = Promosi::whereHas('obat', function($q) use ($mitra) {
                $q->where('mitra_id', $mitra->id);
            })
            ->with('obat')
            ->latest();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'aktif') {
                $query->where('aktif', true)
                      ->where('berakhir', '>=', now());
            } elseif ($request->status == 'nonaktif') {
                $query->where('aktif', false);
            } elseif ($request->status == 'expired') {
                $query->where('berakhir', '<', now());
            }
        }

        $promosis = $query->paginate(10);

        // Statistik
        $totalPromosi = Promosi::whereHas('obat', function($q) use ($mitra) {
            $q->where('mitra_id', $mitra->id);
        })->count();

        $promosiAktif = Promosi::whereHas('obat', function($q) use ($mitra) {
            $q->where('mitra_id', $mitra->id);
        })->where('aktif', true)->where('berakhir', '>=', now())->count();

        $promosiExpired = Promosi::whereHas('obat', function($q) use ($mitra) {
            $q->where('mitra_id', $mitra->id);
        })->where('berakhir', '<', now())->count();

        return view('mitra.promosi.index', compact(
            'promosis',
            'totalPromosi',
            'promosiAktif',
            'promosiExpired'
        ));
    }

    /**
     * Tampilkan form tambah promosi
     */
    public function create()
    {
        $mitra = Auth::user()->mitra;

        // Ambil obat yang aktif dan belum punya promosi aktif
        $obats = $mitra->obats()
            ->where('is_active', true)
            ->orderBy('nama_obat')
            ->get();

        return view('mitra.promosi.create', compact('obats'));
    }

    /**
     * Simpan promosi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'nama_promosi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'diskon' => 'required|integer|min:1|max:100',
            'mulai' => 'required|date',
            'berakhir' => 'required|date|after:mulai',
            'aktif' => 'nullable|boolean',
        ]);

        $mitra = Auth::user()->mitra;

        // Validasi obat milik mitra
        $obat = $mitra->obats()->findOrFail($request->obat_id);

        // Cek apakah obat sudah punya promosi aktif di periode yang sama
        $existing = Promosi::where('obat_id', $request->obat_id)
            ->where('aktif', true)
            ->where(function($q) use ($request) {
                $q->whereBetween('mulai', [$request->mulai, $request->berakhir])
                  ->orWhereBetween('berakhir', [$request->mulai, $request->berakhir])
                  ->orWhere(function($q2) use ($request) {
                      $q2->where('mulai', '<=', $request->mulai)
                         ->where('berakhir', '>=', $request->berakhir);
                  });
            })
            ->exists();

        if ($existing) {
            return back()->withErrors(['error' => 'Obat ini sudah memiliki promosi aktif di periode yang sama.'])->withInput();
        }

        Promosi::create([
            'obat_id' => $request->obat_id,
            'nama_promosi' => $request->nama_promosi,
            'deskripsi' => $request->deskripsi,
            'diskon' => $request->diskon,
            'mulai' => $request->mulai,
            'berakhir' => $request->berakhir,
            'aktif' => $request->has('aktif') ? true : false,
        ]);

        return redirect()->route('mitra.promosi.index')
            ->with('success', 'Promosi berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail promosi
     */
    public function show($id)
    {
        $mitra = Auth::user()->mitra;

        $promosi = Promosi::whereHas('obat', function($q) use ($mitra) {
            $q->where('mitra_id', $mitra->id);
        })->with('obat')->findOrFail($id);

        return view('mitra.promosi.show', compact('promosi'));
    }

    /**
     * Tampilkan form edit promosi
     */
    public function edit($id)
    {
        $mitra = Auth::user()->mitra;

        $promosi = Promosi::whereHas('obat', function($q) use ($mitra) {
            $q->where('mitra_id', $mitra->id);
        })->findOrFail($id);

        $obats = $mitra->obats()
            ->where('is_active', true)
            ->orderBy('nama_obat')
            ->get();

        return view('mitra.promosi.edit', compact('promosi', 'obats'));
    }

    /**
     * Update promosi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'nama_promosi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'diskon' => 'required|integer|min:1|max:100',
            'mulai' => 'required|date',
            'berakhir' => 'required|date|after:mulai',
            'aktif' => 'nullable|boolean',
        ]);

        $mitra = Auth::user()->mitra;

        $promosi = Promosi::whereHas('obat', function($q) use ($mitra) {
            $q->where('mitra_id', $mitra->id);
        })->findOrFail($id);

        // Validasi obat milik mitra
        $obat = $mitra->obats()->findOrFail($request->obat_id);

        $promosi->update([
            'obat_id' => $request->obat_id,
            'nama_promosi' => $request->nama_promosi,
            'deskripsi' => $request->deskripsi,
            'diskon' => $request->diskon,
            'mulai' => $request->mulai,
            'berakhir' => $request->berakhir,
            'aktif' => $request->has('aktif') ? true : false,
        ]);

        return redirect()->route('mitra.promosi.index')
            ->with('success', 'Promosi berhasil diperbarui!');
    }

    /**
     * Toggle status aktif/nonaktif
     */
    public function toggleStatus($id)
    {
        $mitra = Auth::user()->mitra;

        $promosi = Promosi::whereHas('obat', function($q) use ($mitra) {
            $q->where('mitra_id', $mitra->id);
        })->findOrFail($id);

        // Cek apakah promosi sudah expired
        if (Carbon::parse($promosi->berakhir)->isPast()) {
            return back()->withErrors(['error' => 'Tidak dapat mengaktifkan promosi yang sudah berakhir.']);
        }

        $promosi->update(['aktif' => !$promosi->aktif]);

        $status = $promosi->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Promosi berhasil {$status}!");
    }

    /**
     * Hapus promosi
     */
    public function destroy($id)
    {
        $mitra = Auth::user()->mitra;

        $promosi = Promosi::whereHas('obat', function($q) use ($mitra) {
            $q->where('mitra_id', $mitra->id);
        })->findOrFail($id);

        $promosi->delete();

        return redirect()->route('mitra.promosi.index')
            ->with('success', 'Promosi berhasil dihapus!');
    }
}
