<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Obat - CampusCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in-up {
            animation: slideInUp 0.8s ease-out;
        }

        .animate-delay-100 { animation-delay: 0.1s; }
        .animate-delay-200 { animation-delay: 0.2s; }
        .animate-delay-300 { animation-delay: 0.3s; }
        .animate-delay-400 { animation-delay: 0.4s; }

        .obat-card {
            position: relative;
            overflow: hidden;
        }

        .obat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .obat-card:hover::after {
            transform: scaleX(1);
        }
    </style>
</head>
<body class="h-full gradient-bg overflow-x-hidden">
    <div class="relative z-10 min-h-screen">
        <div class="max-w-7xl mx-auto p-6">
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 animate-slide-in-up">
                <div class="mb-4 lg:mb-0">
                    <a href="{{ route('pengguna.dashboard') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors mb-3 group">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Dashboard
                    </a>
                    <h1 class="text-4xl font-bold gradient-text">Katalog Obat 💊</h1>
                    <p class="text-slate-300 mt-2">Temukan obat yang Anda butuhkan dengan mudah dan cepat</p>
                </div>

                <!-- Stats Info -->
                <div class="flex items-center space-x-3 bg-slate-800/50 backdrop-blur-sm rounded-2xl px-6 py-3 border border-slate-700/50">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-pills text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="text-white font-bold text-lg">{{ $obats->total() }}</div>
                            <div class="text-slate-400 text-xs">Total Obat</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Kategori -->
            <div class="glass-card rounded-2xl p-2 mb-8 flex flex-wrap gap-2 animate-slide-in-up animate-delay-100">
                <a href="{{ route('pengguna.obat.index') }}"
                   class="flex-1 min-w-[100px] py-3 px-4 rounded-xl font-medium transition-all duration-300 text-center {{ !request('kategori') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <i class="fas fa-th-large mr-2"></i> Semua
                </a>
                @php
                    $kategoriList = [
                        'Demam' => 'thermometer-half',
                        'Nyeri' => 'head-side-cough',
                        'Batuk' => 'lungs',
                        'Flu' => 'virus',
                        'Maag' => 'stomach',
                        'Diare' => 'toilet',
                        'Alergi' => 'allergies',
                        'Vitamin' => 'pills',
                        'Antiseptik' => 'spray-can',
                        'Perawatan Luka' => 'bandage'
                    ];
                @endphp
                @foreach($kategoriList as $kategori => $icon)
                <a href="{{ route('pengguna.obat.index', ['kategori' => $kategori]) }}"
                   class="flex-1 min-w-[100px] py-3 px-4 rounded-xl font-medium transition-all duration-300 text-center text-sm {{ request('kategori') == $kategori ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <i class="fas fa-{{ $icon }} mr-2"></i>
                    {{ $kategori }}
                </a>
                @endforeach
            </div>

            <!-- Grid Obat -->
            @if($obats->isEmpty())
            <div class="glass-card rounded-2xl p-12 text-center animate-slide-in-up animate-delay-200">
                <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-pills text-slate-500 text-4xl"></i>
                </div>
                <h3 class="text-xl font-medium text-white mb-2">Tidak Ada Obat Tersedia</h3>
                <p class="text-slate-400 mb-6">Coba gunakan filter yang berbeda atau cek kembali nanti</p>
                <a href="{{ route('pengguna.obat.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl text-white font-medium transition-all duration-300">
                    <i class="fas fa-refresh mr-2"></i> Reset Filter
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($obats as $index => $obat)
                <div class="obat-card glass-card rounded-2xl overflow-hidden hover-lift animate-slide-in-up" style="animation-delay: {{ ($index % 8) * 0.05 }}s">
                    <!-- Gambar Obat -->
                    <div class="h-48 bg-gradient-to-br from-blue-500/20 to-purple-500/20 flex items-center justify-center relative overflow-hidden group">
                        @if($obat->gambar)
                        <img src="{{ asset('storage/' . $obat->gambar) }}" alt="{{ $obat->nama }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                        @else
                        <i class="fas fa-pills text-blue-400/50 text-6xl transition-transform duration-300 group-hover:scale-110"></i>
                        @endif

                        <!-- Kategori Badge -->
                        <span class="absolute top-3 right-3 px-3 py-1 text-xs rounded-full font-medium backdrop-blur-sm
                            @if($obat->kategori == 'obat_keras') bg-red-500/80 text-white
                            @elseif($obat->kategori == 'obat_bebas') bg-green-500/80 text-white
                            @else bg-blue-500/80 text-white
                            @endif">
                            {{ str_replace('_', ' ', $obat->kategori) }}
                        </span>

                        <!-- Stok Badge -->
                        @if($obat->stok <= 10 && $obat->stok > 0)
                        <span class="absolute top-3 left-3 px-3 py-1 text-xs rounded-full font-medium bg-orange-500/80 text-white backdrop-blur-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i> Stok Terbatas
                        </span>
                        @elseif($obat->stok == 0)
                        <span class="absolute top-3 left-3 px-3 py-1 text-xs rounded-full font-medium bg-red-500/80 text-white backdrop-blur-sm">
                            <i class="fas fa-times-circle mr-1"></i> Habis
                        </span>
                        @endif
                    </div>

                    <!-- Informasi Obat -->
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-white mb-2 line-clamp-1">{{ $obat->nama }}</h3>

                        <div class="flex items-center text-slate-400 text-sm mb-3">
                            <i class="fas fa-store mr-2 text-blue-400"></i>
                            <span class="line-clamp-1">{{ $obat->mitra->nama_apotek ?? 'Apotek' }}</span>
                        </div>

                        <!-- Deskripsi singkat -->
                        <p class="text-slate-300 text-sm mb-4 line-clamp-2 min-h-[40px]">
                            {{ Str::limit($obat->deskripsi, 80) }}
                        </p>

                        <!-- Harga dan Stok -->
                        <div class="flex justify-between items-end mb-4 pb-4 border-b border-slate-700/50">
                            <div>
                                <span class="text-slate-400 text-xs block mb-1">Harga</span>
                                <span class="text-2xl font-bold text-white">
                                    Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                </span>
                                <span class="text-slate-400 text-sm">/{{ $obat->satuan }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-slate-400 text-xs block mb-1">Stok</span>
                                <span class="text-lg font-bold @if($obat->stok > 10) text-green-400 @elseif($obat->stok > 0) text-orange-400 @else text-red-400 @endif">
                                    {{ $obat->stok }}
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex space-x-2">
                            <a href="{{ route('pengguna.obat.show', $obat->id) }}"
                               class="flex-1 bg-slate-700/50 hover:bg-slate-600 text-white py-2.5 text-center rounded-xl transition-all duration-300 font-medium text-sm">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                            @if($obat->stok > 0)
                            <a href="{{ route('pengguna.obat.pesan', $obat->id) }}"
                               class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-2.5 text-center rounded-xl transition-all duration-300 font-medium text-sm">
                                <i class="fas fa-shopping-cart mr-1"></i> Beli
                            </a>
                            @else
                            <button disabled class="flex-1 bg-slate-700/30 text-slate-500 py-2.5 text-center rounded-xl cursor-not-allowed font-medium text-sm">
                                <i class="fas fa-times mr-1"></i> Habis
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($obats->hasPages())
            <div class="glass-card rounded-2xl p-6 animate-slide-in-up">
                <div class="flex justify-center">
                    {{ $obats->links() }}
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>

    <script>
        // Add staggered animation to obat cards
        document.addEventListener('DOMContentLoaded', function() {
            const obatCards = document.querySelectorAll('.obat-card');
            obatCards.forEach((card, index) => {
                card.style.animationDelay = `${(index % 8) * 0.05}s`;
            });
        });
    </script>
</body>
</html>
