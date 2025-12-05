<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MitraAuthController extends Controller
{
    // Tampilkan form register mitra
    public function showRegisterForm()
    {
        return view('mitra.auth.register');
    }

    // Proses registrasi mitra
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nama_apotek' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            // Buat user dengan role mitra
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mitra',
            ]);

            // Buat profil mitra
            Mitra::create([
                'user_id' => $user->id,
                'nama_apotek' => $request->nama_apotek,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'rating' => 0,
                'aktif' => false, // Menunggu approval admin
            ]);

            DB::commit();

            return redirect()->route('mitra.login')
                ->with('success', 'Registrasi berhasil! Akun Anda menunggu persetujuan admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi.'])->withInput();
        }
    }

    // Tampilkan form login mitra
    public function showLoginForm()
    {
        return view('mitra.auth.login');
    }

    // Proses login mitra
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek apakah user adalah mitra
            if ($user->role !== 'mitra') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini bukan akun mitra.']);
            }

            // Cek apakah mitra sudah diaktifkan
            $mitra = $user->mitra;
            if (!$mitra || !$mitra->aktif) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun Anda belum diaktifkan oleh admin.']);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('mitra.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    // Dashboard mitra
    public function dashboard()
    {
        $user = Auth::user();
        $mitra = $user->mitra;

        // Statistik untuk dashboard
        $totalObat = $mitra->obats()->count();

        // Cek apakah relationship orders ada - PAKAI TRY-CATCH
        try {
            $totalPesanan = $mitra->orders()->count();
            $pesananBaru = $mitra->orders()->where('status', 'pending')->count();
            $pendapatanBulanIni = $mitra->orders()
                ->where('status', 'selesai')
                ->whereMonth('created_at', now()->month)
                ->sum('total_harga');

            // Pesanan terbaru
            $pesananTerbaru = $mitra->orders()
                ->with(['user', 'orderItems.obat'])
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // Jika relationship belum siap, gunakan default values
            $totalPesanan = 0;
            $pesananBaru = 0;
            $pendapatanBulanIni = 0;
            $pesananTerbaru = collect([]);
        }

        // Obat dengan stok rendah
        $obatStokRendah = $mitra->obats()
            ->where('stok', '<', 10)
            ->get();

        return view('mitra.dashboard', compact(
            'mitra',
            'totalObat',
            'totalPesanan',
            'pesananBaru',
            'pendapatanBulanIni',
            'pesananTerbaru',
            'obatStokRendah'
        ));
    }

    // Logout mitra
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('mitra.login');
    }
}
