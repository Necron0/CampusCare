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
        $stats = [
            'total_obat_terjual' => OrderItem::sum('qty'),
            'total_konsultasi' => Konsultasi::count(),
            'total_ulasan' => Ulasan::count(),
            'avg_rating' => number_format(Ulasan::avg('rating'), 1),
        ];

        $obatTerlaris = OrderItem::select('obat_id', DB::raw('SUM(qty) as total_terjual'))
            ->groupBy('obat_id')
            ->orderByDesc('total_terjual')
            ->take(10)
            ->with('obat.mitra')
            ->get();

        $obatLabels = $obatTerlaris->pluck('obat.nama')->toArray();
        $obatData = $obatTerlaris->pluck('total_terjual')->toArray();

        $topikTerbanyak = Konsultasi::select('topik', DB::raw('COUNT(*) as total'))
            ->groupBy('topik')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $topikLabels = $topikTerbanyak->pluck('topik')->toArray();
        $topikData = $topikTerbanyak->pluck('total')->toArray();

        $ratingDistribution = Ulasan::select('rating', DB::raw('COUNT(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating')
            ->get();

        $ratingLabels = ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'];
        $ratingData = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingData[] = $ratingDistribution->where('rating', $i)->first()->total ?? 0;
        }

        $topMitras = Mitra::withCount('ulasans')
            ->withAvg('ulasans', 'rating')
            ->orderByDesc('ulasans_avg_rating')
            ->take(5)
            ->get()
            ->map(function ($mitra) {
                $mitra->rating = number_format($mitra->ulasans_avg_rating ?? 0, 1);
                return $mitra;
            });

        $recentReviews = Ulasan::with(['user', 'order.mitra'])
            ->latest()
            ->take(5)
            ->get();

        $bulanLabels = [];
        $pesananData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $bulanLabels[] = $date->format('M Y');
            $pesananData[] = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
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
