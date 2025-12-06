<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mitra;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Konsultasi;
use App\Models\Ulasan;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // ===== STATISTIK CARDS =====
        $stats = [
            'total_obat_terjual' => OrderItem::sum('qty') ?? 0,
            'total_konsultasi' => Konsultasi::count(),
            'total_ulasan' => Ulasan::count(),
            'avg_rating' => Ulasan::count() > 0 ? number_format(Ulasan::avg('rating'), 1) : '0.0',
        ];

        // ===== TOP 10 OBAT TERLARIS =====
        $obatTerlaris = OrderItem::selectRaw('obat_id, SUM(qty) as total_terjual')
            ->groupBy('obat_id')
            ->orderByDesc('total_terjual')
            ->take(10)
            ->get();

        // Load relasi obat dan mitra
        $obatTerlaris->load(['obat' => function($query) {
            $query->withTrashed()->with('mitra');
        }]);

        // Data untuk Chart Bar
        $obatLabels = $obatTerlaris->map(function($item) {
            if (!$item->obat) {
                return 'Obat Dihapus';
            }
            $nama = $item->obat->nama_obat;
            return strlen($nama) > 20 ? substr($nama, 0, 20) . '...' : $nama;
        })->toArray();

        $obatData = $obatTerlaris->pluck('total_terjual')->toArray();

        // Jika tidak ada data
        if (empty($obatLabels)) {
            $obatLabels = ['Belum ada data'];
            $obatData = [0];
        }

        // ===== TOPIK KONSULTASI TERBANYAK =====
        $topikTerbanyak = Konsultasi::select('topik', DB::raw('COUNT(*) as total'))
            ->whereNotNull('topik')
            ->groupBy('topik')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $topikLabels = $topikTerbanyak->pluck('topik')->toArray();
        $topikData = $topikTerbanyak->pluck('total')->toArray();

        // Jika tidak ada data
        if (empty($topikLabels)) {
            $topikLabels = ['Belum ada data'];
            $topikData = [0];
        }

        // ===== DISTRIBUSI RATING =====
        $ratingDistribution = Ulasan::select('rating', DB::raw('COUNT(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating')
            ->get()
            ->keyBy('rating');

        $ratingLabels = ['1 Bintang', '2 Bintang', '3 Bintang', '4 Bintang', '5 Bintang'];
        $ratingData = [];

        for ($i = 1; $i <= 5; $i++) {
            $ratingData[] = $ratingDistribution->get($i)->total ?? 0;
        }

        // ===== TOP 5 APOTEK RATING TERTINGGI =====
        $topMitras = Mitra::withCount('ulasans')
            ->withAvg('ulasans', 'rating')
            ->orderByDesc('ulasans_avg_rating')
            ->get()
            ->filter(function ($mitra) {
                return $mitra->ulasans_count > 0;
            })
            ->map(function ($mitra) {
                $mitra->rating = number_format($mitra->ulasans_avg_rating ?? 0, 1);
                return $mitra;
            })
            ->take(5);

        // ===== ULASAN TERBARU =====
        $recentReviews = Ulasan::with(['user', 'order.mitra'])
            ->latest()
            ->take(5)
            ->get();

        // ===== TREND PESANAN 6 BULAN TERAKHIR =====
        $bulanLabels = [];
        $pesananData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $bulanLabels[] = $date->translatedFormat('M Y');

            $count = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $pesananData[] = $count;
        }

        return view('admin.analytics', compact(
            'stats',
            'obatTerlaris',
            'obatLabels',
            'obatData',
            'topikTerbanyak',
            'topikLabels',
            'topikData',
            'ratingLabels',
            'ratingData',
            'topMitras',
            'recentReviews',
            'bulanLabels',
            'pesananData'
        ));
    }
}
