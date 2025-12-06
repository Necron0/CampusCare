<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - CampusCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="min-h-screen text-white bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700">
    <div class="max-w-7xl mx-auto p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('pengguna.dashboard') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors mb-2 group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Dashboard
                </a>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                    Riwayat Pesanan
                </h1>
                <p class="text-slate-300 mt-2">Pesanan yang sudah selesai atau dibatalkan</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-300 text-sm mb-1">Total Pesanan</p>
                <h3 class="text-3xl font-bold text-white">{{ $stats['total'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-blue-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-shopping-bag text-blue-400 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-300 text-sm mb-1">Selesai</p>
                <h3 class="text-3xl font-bold text-white">{{ $stats['selesai'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-green-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-400 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-300 text-sm mb-1">Dibatalkan</p>
                <h3 class="text-3xl font-bold text-white">{{ $stats['dibatalkan'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-red-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-times-circle text-red-400 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-300 text-sm mb-1">Total Belanja</p>
                <h3 class="text-2xl font-bold text-white">Rp {{ number_format($stats['total_belanja'], 0, ',', '.') }}</h3>
            </div>
            <div class="w-14 h-14 bg-purple-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-wallet text-purple-400 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

        <!-- Filter -->
       <!-- Filter -->
<div class="glass-card rounded-2xl p-2 mb-8 flex space-x-2">
    <button onclick="filterOrders('semua')" class="filter-btn flex-1 py-3 px-4 rounded-xl font-medium transition-all duration-300 bg-blue-600 text-white">
        Semua
    </button>
    <button onclick="filterOrders('pending')" class="filter-btn flex-1 py-3 px-4 rounded-xl font-medium transition-all duration-300 text-slate-300 hover:bg-slate-700/50">
        Pending
    </button>
    <button onclick="filterOrders('diproses')" class="filter-btn flex-1 py-3 px-4 rounded-xl font-medium transition-all duration-300 text-slate-300 hover:bg-slate-700/50">
        Diproses
    </button>
    <button onclick="filterOrders('selesai')" class="filter-btn flex-1 py-3 px-4 rounded-xl font-medium transition-all duration-300 text-slate-300 hover:bg-slate-700/50">
        Selesai
    </button>
    <button onclick="filterOrders('dibatalkan')" class="filter-btn flex-1 py-3 px-4 rounded-xl font-medium transition-all duration-300 text-slate-300 hover:bg-slate-700/50">
        Dibatalkan
    </button>
</div>

        <!-- Orders List -->
        <div class="space-y-4" id="orders-list">
            @forelse($orders as $order)
<div class="glass-card rounded-2xl p-6 hover:shadow-xl transition-all duration-300 order-item" data-status="{{ $order->status }}">
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-2">
                <h3 class="text-lg font-semibold text-white">Order #{{ $order->id }}</h3>
                <span class="px-3 py-1 rounded-full text-xs font-medium
                    @if($order->status == 'selesai') bg-green-500/20 text-green-400
                    @elseif($order->status == 'dibatalkan') bg-red-500/20 text-red-400
                    @elseif($order->status == 'pending') bg-yellow-500/20 text-yellow-400
                    @elseif($order->status == 'diproses') bg-blue-500/20 text-blue-400
                    @elseif($order->status == 'dikirim') bg-purple-500/20 text-purple-400
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="space-y-2 text-slate-300 text-sm">
                <div class="flex items-center">
                    <i class="fas fa-store text-blue-400 mr-2 w-4"></i>
                    <span>{{ $order->mitra->nama_apotek ?? 'Apotek' }}</span>
                </div>

                <div class="flex items-center">
                    <i class="fas fa-calendar text-purple-400 mr-2 w-4"></i>
                    <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>

                <div class="flex items-center">
                    <i class="fas fa-box text-yellow-400 mr-2 w-4"></i>
                    <span>{{ $order->items->count() }} item</span>
                </div>
            </div>
        </div>

        <div class="text-right ml-4">
            <p class="text-slate-400 text-sm mb-1">Total</p>
            <p class="text-2xl font-bold text-white">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
            <a href="{{ route('pengguna.pesanan.show', $order->id) }}"
               class="mt-3 inline-block bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition-all duration-300 text-sm">
                <i class="fas fa-eye mr-2"></i> Detail
            </a>
        </div>
    </div>

    <!-- Items Preview -->
    <div class="border-t border-slate-700 pt-4 mt-4">
        <p class="text-slate-400 text-sm mb-2">Item Pesanan:</p>
        <div class="space-y-2">
            @foreach($order->items->take(3) as $item)
            <div class="flex items-center justify-between text-sm">
                <span class="text-slate-300">
                    <i class="fas fa-pills text-blue-400 mr-2"></i>
                    {{ $item->obat ? $item->obat->nama_obat : 'Obat tidak ditemukan' }} × {{ $item->qty }}
                </span>
                <span class="text-slate-300">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach

            @if($order->items->count() > 3)
            <p class="text-slate-500 text-xs">
                +{{ $order->items->count() - 3 }} item lainnya
            </p>
            @endif
        </div>
    </div>
</div>
@empty
            <div class="glass-card rounded-2xl p-12 text-center">
                <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-slate-500 text-4xl"></i>
                </div>
                <h3 class="text-xl font-medium text-white mb-2">Belum Ada Riwayat</h3>
                <p class="text-slate-400 mb-6">Anda belum memiliki riwayat pesanan</p>
                <a href="{{ route('pengguna.obat.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl text-white font-medium transition-all duration-300">
                    <i class="fas fa-shopping-cart mr-2"></i> Mulai Belanja
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

    <script>
        function filterOrders(status) {
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('text-slate-300');
            });
            event.target.classList.add('bg-blue-600', 'text-white');
            event.target.classList.remove('text-slate-300');

            // Filter items
            const items = document.querySelectorAll('.order-item');
            items.forEach(item => {
                if (status === 'semua' || item.dataset.status === status) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
