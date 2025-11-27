<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\PesananDetail;
use App\Models\Konsultasi;
use App\Models\Ulasan;
use App\Models\Mitra;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $obatTerlaris = PesananDetail::select('obat_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->with('obat.mitra')
            ->groupBy('obat_id')
            ->orderBy('total_terjual', 'desc')
            ->limit(10)
            ->get();


        $obatLabels = $obatTerlaris->pluck('obat.nama')->toArray();
        $obatData = $obatTerlaris->pluck('total_terjual')->toArray();

        $topikTerbanyak = Konsultasi::select('topik', DB::raw('COUNT(*) as total'))
            ->whereNotNull('topik')
            ->groupBy('topik')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $topikLabels = $topikTerbanyak->pluck('topik')->toArray();
        $topikData = $topikTerbanyak->pluck('total')->toArray();


        $ratingDistribution = Ulasan::select('rating', DB::raw('COUNT(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();

        $ratingLabels = $ratingDistribution->pluck('rating')->map(function($r) {
            return $r . ' Bintang';
        })->toArray();
        $ratingData = $ratingDistribution->pluck('total')->toArray();

        $topMitras = Mitra::with('ulasans')
            ->where('aktif', true)
            ->withCount('ulasans')
            ->orderBy('rating', 'desc')
            ->limit(5)
            ->get();

        $recentReviews = Ulasan::with(['user', 'pesanan.mitra'])
            ->latest()
            ->limit(10)
            ->get();

        $stats = [
            'total_obat_terjual' => PesananDetail::sum('jumlah'),
            'total_konsultasi' => Konsultasi::count(),
            'total_ulasan' => Ulasan::count(),
            'avg_rating' => round(Ulasan::avg('rating'), 1) ?? 0,
            'total_revenue' => Pesanan::where('status', 'selesai')->sum('total'),
        ];

        $pesananBulanan = Pesanan::select(
                DB::raw("TO_CHAR(created_at, 'YYYY-MM') as bulan"),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(total) as revenue')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        $bulanLabels = $pesananBulanan->pluck('bulan')->map(function($bulan) {
            return date('M Y', strtotime($bulan . '-01'));
        })->toArray();
        $pesananData = $pesananBulanan->pluck('total')->toArray();

        return view('admin.Analytics', compact(
            'obatLabels',
            'obatData',
            'topikLabels',
            'topikData',
            'ratingLabels',
            'ratingData',
            'topMitras',
            'recentReviews',
            'stats',
            'obatTerlaris',
            'topikTerbanyak',
            'bulanLabels',
            'pesananData'
        ));
    }
}
