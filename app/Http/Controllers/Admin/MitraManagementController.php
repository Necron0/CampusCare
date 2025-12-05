<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MitraManagementController extends Controller
{
    public function index()
    {
        $mitras = Mitra::with('user')
            ->withCount('orders')
            ->latest()
            ->paginate(10);

        $stats = [
            'total_mitras' => Mitra::count(),
            'active_mitras' => Mitra::where('aktif', true)->count(),
            'inactive_mitras' => Mitra::where('aktif', false)->count(),
            'avg_rating' => round(Mitra::avg('rating'), 1),
        ];

        return view('admin.ManajemenMitra', compact('mitras', 'stats'));
    }

    public function store(Request $request)
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
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mitra',
            ]);

            Mitra::create([
                'user_id' => $user->id,
                'nama_apotek' => $request->nama_apotek,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'rating' => 0,
                'aktif' => true,
            ]);

            DB::commit();
            return redirect()->route('admin.mitra-management.index')
                ->with('success', 'Mitra berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan mitra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $mitra = Mitra::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $mitra->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'nama_apotek' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            $user = $mitra->user;
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Update mitra
            $mitra->update([
                'nama_apotek' => $request->nama_apotek,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
            ]);

            DB::commit();
            return redirect()->route('admin.mitra-management.index')
                ->with('success', 'Mitra berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mengupdate mitra: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $mitra = Mitra::findOrFail($id);

        $newStatus = !$mitra->aktif;
        $mitra->update(['aktif' => $newStatus]);

        $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.mitra-management.index')
            ->with('success', "Mitra berhasil {$statusText}!");
    }

    public function destroy($id)
    {
        $mitra = Mitra::findOrFail($id);

        DB::beginTransaction();
        try {
            $user = $mitra->user;
            $mitra->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('admin.mitra-management.index')
                ->with('success', 'Mitra berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus mitra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $mitra = Mitra::with(['user', 'orders', 'ulasans', 'konsultasis'])
            ->withCount(['orders', 'ulasans', 'konsultasis'])
            ->findOrFail($id);

        $totalRevenue = $mitra->orders()->sum('total_harga');

        $recentOrders = $mitra->orders()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();


        $recentReviews = $mitra->ulasans()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $performance = [
            'total_orders' => $mitra->orders_count,
            'total_revenue' => $totalRevenue,
            'rating' => $mitra->rating,
            'total_reviews' => $mitra->ulasans_count,
            'total_consultations' => $mitra->konsultasis_count,
        ];

        return view('admin.ManajemenMitraDetail', compact('mitra', 'performance', 'recentOrders', 'recentReviews'));
    }
}
