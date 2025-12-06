<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->id }} - CampusCare</title>
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
    <div class="max-w-5xl mx-auto p-6">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('pengguna.riwayat.index') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors mb-4 group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Riwayat
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Detail Pesanan</h1>
                    <p class="text-slate-400 mt-1">Order #{{ $order->id }}</p>
                </div>
                <span class="px-4 py-2 rounded-xl text-sm font-medium
                    @if($order->status == 'selesai') bg-green-500/20 text-green-400
                    @elseif($order->status == 'dibatalkan') bg-red-500/20 text-red-400
                    @elseif($order->status == 'pending') bg-yellow-500/20 text-yellow-400
                    @elseif($order->status == 'diproses') bg-blue-500/20 text-blue-400
                    @elseif($order->status == 'dikirim') bg-purple-500/20 text-purple-400
                    @endif">
                    <i class="fas fa-circle text-xs mr-1"></i>
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Apotek -->
                <div class="glass-card rounded-2xl p-6">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-store text-blue-400 mr-2"></i>
                        Informasi Apotek
                    </h2>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-building text-slate-400 mr-3 mt-1"></i>
                            <div>
                                <p class="text-slate-400 text-sm">Nama Apotek</p>
                                <p class="text-white font-medium">{{ $order->mitra->nama_apotek ?? 'Apotek' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-slate-400 mr-3 mt-1"></i>
                            <div>
                                <p class="text-slate-400 text-sm">Alamat</p>
                                <p class="text-white">{{ $order->mitra->alamat ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-phone text-slate-400 mr-3 mt-1"></i>
                            <div>
                                <p class="text-slate-400 text-sm">Telepon</p>
                                <p class="text-white">{{ $order->mitra->telepon ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item Pesanan -->
                <div class="glass-card rounded-2xl p-6">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-pills text-purple-400 mr-2"></i>
                        Item Pesanan
                    </h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center justify-between p-4 bg-slate-800/50 rounded-xl">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-slate-700 rounded-lg flex items-center justify-center">
                                    @if($item->obat && $item->obat->gambar)
                                        <img src="{{ asset('storage/' . $item->obat->gambar) }}" alt="{{ $item->obat->nama_obat }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <i class="fas fa-pills text-slate-400 text-2xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-medium text-white">
                                        {{ $item->obat ? $item->obat->nama_obat : 'Obat tidak ditemukan' }}
                                    </h3>
                                    <p class="text-slate-400 text-sm">
                                        Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->qty }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Informasi Pengiriman -->
                <div class="glass-card rounded-2xl p-6">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-shipping-fast text-green-400 mr-2"></i>
                        Informasi Pengiriman
                    </h2>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-user text-slate-400 mr-3 mt-1"></i>
                            <div>
                                <p class="text-slate-400 text-sm">Nama Penerima</p>
                                <p class="text-white font-medium">{{ $order->nama_penerima }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-phone text-slate-400 mr-3 mt-1"></i>
                            <div>
                                <p class="text-slate-400 text-sm">No. HP</p>
                                <p class="text-white">{{ $order->no_hp }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-slate-400 mr-3 mt-1"></i>
                            <div>
                                <p class="text-slate-400 text-sm">Alamat Pengiriman</p>
                                <p class="text-white">{{ $order->alamat_pengiriman }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-truck text-slate-400 mr-3 mt-1"></i>
                            <div>
                                <p class="text-slate-400 text-sm">Opsi Pengiriman</p>
                                <p class="text-white font-medium">{{ ucfirst($order->opsi_pengiriman) }}</p>
                            </div>
                        </div>
                        @if($order->catatan)
                        <div class="flex items-start">
                            <i class="fas fa-sticky-note text-slate-400 mr-3 mt-1"></i>
                            <div>
                                <p class="text-slate-400 text-sm">Catatan</p>
                                <p class="text-white">{{ $order->catatan }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Ringkasan Pembayaran -->
                <div class="glass-card rounded-2xl p-6">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-receipt text-yellow-400 mr-2"></i>
                        Ringkasan
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between text-slate-300">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-300">
                            <span>Ongkir</span>
                            <span>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-slate-700 pt-3 flex justify-between text-white font-semibold text-lg">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="glass-card rounded-2xl p-6">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-clock text-blue-400 mr-2"></i>
                        Informasi Waktu
                    </h2>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-calendar-plus text-slate-400 mr-3 mt-1"></i>
                            <div>
                                <p class="text-slate-400 text-sm">Tanggal Pesan</p>
                                <p class="text-white font-medium">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @if($order->updated_at != $order->created_at)
                        <div class="flex items-start">
                            <i class="fas fa-calendar-check text-slate-400 mr-3 mt-1"></i>
                            <div>
                                <p class="text-slate-400 text-sm">Terakhir Diupdate</p>
                                <p class="text-white font-medium">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($order->status == 'pending')
                <div class="glass-card rounded-2xl p-6">
                    <button class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-medium transition-all duration-300">
                        <i class="fas fa-times-circle mr-2"></i>
                        Batalkan Pesanan
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
