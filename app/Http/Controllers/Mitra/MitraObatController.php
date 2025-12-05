<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MitraObatController extends Controller
{
    // Tampilkan daftar obat milik mitra
    public function index()
    {
        $mitra = Auth::user()->mitra;
        $obats = $mitra->obats()->paginate(10);

        return view('mitra.obat.index', compact('obats'));
    }

    // Tampilkan form tambah obat
    public function create()
    {
        return view('mitra.obat.create');
    }

    // Simpan obat baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'gejala' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'lokasi_apotek' => 'nullable|string',
            'is_active' => 'nullable|boolean',     
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $mitra = Auth::user()->mitra;

        $data = $request->except('gambar');
        $data['mitra_id'] = $mitra->id;

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('obat', 'public');
        }

        Obat::create($data);

        return redirect()->route('mitra.obat.index')
            ->with('success', 'Obat berhasil ditambahkan!');
    }

    // Tampilkan detail obat
    public function show($id)
    {
        $mitra = Auth::user()->mitra;
        $obat = $mitra->obats()->findOrFail($id);

        return view('mitra.obat.show', compact('obat'));
    }

    // Tampilkan form edit obat
    public function edit($id)
    {
        $mitra = Auth::user()->mitra;
        $obat = $mitra->obats()->findOrFail($id);

        return view('mitra.obat.edit', compact('obat'));
    }

    // Update obat
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'required|string',
            'efek_samping' => 'nullable|string',
            'cara_pakai' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $mitra = Auth::user()->mitra;
        $obat = $mitra->obats()->findOrFail($id);

        $data = $request->except('gambar');

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($obat->gambar) {
                Storage::disk('public')->delete($obat->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('obat', 'public');
        }

        $obat->update($data);

        return redirect()->route('mitra.obat.index')
            ->with('success', 'Obat berhasil diperbarui!');
    }

    // Hapus obat
    public function destroy($id)
    {
        $mitra = Auth::user()->mitra;
        $obat = $mitra->obats()->findOrFail($id);

        // Hapus gambar jika ada
        if ($obat->gambar) {
            Storage::disk('public')->delete($obat->gambar);
        }

        $obat->delete();

        return redirect()->route('mitra.obat.index')
            ->with('success', 'Obat berhasil dihapus!');
    }

    // Update stok obat (AJAX)
    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
        ]);

        $mitra = Auth::user()->mitra;
        $obat = $mitra->obats()->findOrFail($id);

        $obat->update(['stok' => $request->stok]);

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil diperbarui!',
            'stok' => $obat->stok
        ]);
    }
}
