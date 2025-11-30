<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Obat - CampusCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'gradient-shift': 'gradientShift 15s ease infinite',
                        'pulse-glow': 'pulseGlow 2s ease-in-out infinite alternate',
                        'float': 'floating 6s ease-in-out infinite',
                    },
                    keyframes: {
                        gradientShift: {
                            '0%, 100%': { 'background-position': '0% 50%' },
                            '50%': { 'background-position': '100% 50%' }
                        },
                        pulseGlow: {
                            'from': { 'box-shadow': '0 0 20px rgba(96, 165, 250, 0.3)' },
                            'to': { 'box-shadow': '0 0 30px rgba(96, 165, 250, 0.6)' }
                        },
                        floating: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-10px) rotate(1deg)' }
                        }
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .medication-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent);
            transition: left 0.6s ease;
        }

        .medication-card:hover::before {
            left: 100%;
        }
    </style>
</head>
<body class="min-h-screen text-white bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 animate-gradient-shift bg-[length:400%_400%]">
    <div class="max-w-7xl mx-auto p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('pengguna.dashboard') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors mb-2 group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Dashboard
                </a>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Katalog Obat</h1>
                <p class="text-slate-300 mt-2">Temukan obat yang tepat untuk kebutuhan kesehatan Anda</p>
            </div>
            <div class="hidden md:flex items-center space-x-3 glass-card rounded-2xl px-4 py-3">
                <i class="fas fa-capsules text-blue-400 text-xl"></i>
                <div>
                    <div class="text-white font-medium">{{ $obats->total() }} Obat</div>
                    <div class="text-slate-400 text-xs">Tersedia</div>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <form method="GET" class="glass-card rounded-2xl p-6 mb-8 transition-all duration-300 hover:shadow-xl">
            <div class="grid md:grid-cols-4 gap-4">
                <div class="md:col-span-3">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="q" value="{{ request('q') }}"
                               placeholder="Cari berdasarkan nama obat, gejala, atau kategori..."
                               class="w-full bg-slate-800/50 border border-slate-700 rounded-xl pl-12 pr-4 py-4 text-white placeholder-slate-400 outline-none transition-all duration-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="flex gap-3">
                    <button class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-4 rounded-xl w-full transition-all duration-300 flex items-center justify-center animate-pulse-glow">
                        <i class="fas fa-filter mr-2"></i> Terapkan
                    </button>
                    <a href="{{ route('pengguna.obat.index') }}"
                       class="bg-slate-700 hover:bg-slate-600 text-white px-6 py-4 rounded-xl w-full transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-refresh mr-2"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Medication Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($obats as $obat)
                <div class="medication-card glass-card rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-xl group">
                    <!-- Header dengan ikon dan kategori -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-xl flex items-center justify-center animate-float">
                            <i class="fas fa-capsules text-blue-400 text-lg"></i>
                        </div>
                        <span class="bg-slate-700/50 text-slate-300 text-xs px-3 py-1 rounded-full">
                            {{ $obat->kategori ?? 'Umum' }}
                        </span>
                    </div>

                    <!-- Nama dan Deskripsi -->
                    <h3 class="font-bold text-xl text-white mb-2 group-hover:text-blue-300 transition-colors duration-300">
                        {{ $obat->nama }}
                    </h3>
                    <p class="text-slate-300 text-sm mb-4 line-clamp-2">
                        {{ $obat->gejala ?? 'Obat untuk berbagai kebutuhan kesehatan' }}
                    </p>

                    <!-- Info Lokasi -->
                    <div class="flex items-center text-slate-400 text-sm mb-4">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-400"></i>
                        <span class="truncate">{{ $obat->lokasi_apotek ?? 'Lokasi tersedia' }}</span>
                    </div>

                    <!-- Footer dengan harga dan action -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-700/50">
                        <div>
                            <p class="font-bold text-green-400 text-lg">
                                Rp {{ number_format($obat->harga, 0, ',', '.') }}
                            </p>
                            <p class="text-slate-400 text-xs">Stok: {{ $obat->stok }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('pengguna.obat.show', $obat->id) }}"
                               class="bg-slate-700 hover:bg-slate-600 text-white p-2 rounded-lg transition-all duration-300 hover:scale-110"
                               title="Detail Obat">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('pengguna.order.create', $obat->id) }}"
                               class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 flex items-center hover:scale-105">
                                <i class="fas fa-shopping-cart mr-2"></i> Pesan
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-3 text-center py-12">
                    <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-capsules text-slate-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-white mb-2">Obat tidak ditemukan</h3>
                    <p class="text-slate-400 mb-6">Coba ubah kata kunci pencarian atau filter</p>
                    <a href="{{ route('pengguna.obat.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl text-white font-medium transition-all duration-300 hover:scale-105">
                        <i class="fas fa-refresh mr-2"></i> Tampilkan Semua Obat
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(method_exists($obats, 'links') && $obats->hasPages())
            <div class="mt-8 glass-card rounded-2xl p-6">
                {{ $obats->links() }}
            </div>
        @endif
    </div>

    <script>
        // Add interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add stagger animation to cards
            const cards = document.querySelectorAll('.medication-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>
