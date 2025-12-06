<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Kesehatan - CampusCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        .doctor-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(96, 165, 250, 0.3); }
            50% { box-shadow: 0 0 30px rgba(96, 165, 250, 0.6); }
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
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
                <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Konsultasi Kesehatan</h1>
                <p class="text-slate-300 mt-2">Konsultasi dengan tenaga medis profesional kapan saja</p>
            </div>

            <a href="{{ route('pengguna.konsultasi.create') }}"
               class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 animate-pulse-glow flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Konsultasi Baru
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-300 text-sm mb-1">Total Konsultasi</p>
                        <h3 class="text-3xl font-bold text-white">{{ $totalKonsultasi ?? 0 }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-blue-500/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-comments text-blue-400 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-300 text-sm mb-1">Konsultasi Aktif</p>
                        <h3 class="text-3xl font-bold text-white">{{ $konsultasiAktif ?? 0 }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-green-500/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-md text-green-400 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-300 text-sm mb-1">Konsultasi Selesai</p>
                        <h3 class="text-3xl font-bold text-white">{{ $konsultasiSelesai ?? 0 }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-purple-500/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-purple-400 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="glass-card rounded-2xl p-2 mb-8 flex space-x-2">
            <button onclick="filterKonsultasi('semua')"
                    class="filter-btn flex-1 py-3 px-4 rounded-xl font-medium transition-all duration-300 bg-blue-600 text-white">
                Semua
            </button>
            <button onclick="filterKonsultasi('menunggu')"
                    class="filter-btn flex-1 py-3 px-4 rounded-xl font-medium transition-all duration-300 text-slate-300 hover:bg-slate-700/50">
                Menunggu
            </button>
            <button onclick="filterKonsultasi('diproses')"
                    class="filter-btn flex-1 py-3 px-4 rounded-xl font-medium transition-all duration-300 text-slate-300 hover:bg-slate-700/50">
                Diproses
            </button>
            <button onclick="filterKonsultasi('selesai')"
                    class="filter-btn flex-1 py-3 px-4 rounded-xl font-medium transition-all duration-300 text-slate-300 hover:bg-slate-700/50">
                Selesai
            </button>
        </div>

        <!-- Konsultasi List -->
        <div class="space-y-4" id="konsultasi-list">
            @forelse($konsultasis ?? [] as $konsultasi)
            <div class="glass-card rounded-2xl p-6 hover:shadow-xl transition-all duration-300 konsultasi-item" data-status="{{ $konsultasi->status }}">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4 flex-1">
                        <!-- Icon Status -->
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0
                            @if($konsultasi->status == 'menunggu') bg-yellow-500/20
                            @elseif($konsultasi->status == 'diproses') bg-blue-500/20
                            @else bg-green-500/20
                            @endif">
                            <i class="fas
                                @if($konsultasi->status == 'menunggu') fa-clock text-yellow-400
                                @elseif($konsultasi->status == 'diproses') fa-user-md text-blue-400
                                @else fa-check-circle text-green-400
                                @endif text-xl"></i>
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-lg font-semibold text-white">Konsultasi #{{ $konsultasi->id }}</h3>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($konsultasi->status == 'menunggu') bg-yellow-500/20 text-yellow-400
                                    @elseif($konsultasi->status == 'diproses') bg-blue-500/20 text-blue-400
                                    @else bg-green-500/20 text-green-400
                                    @endif">
                                    {{ ucfirst($konsultasi->status) }}
                                </span>
                            </div>

                            <div class="space-y-2 text-slate-300">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-stethoscope text-blue-400 mr-2 w-4"></i>
                                    <span class="font-medium">Keluhan:</span>
                                    <span class="ml-2">{{ $konsultasi->keluhan }}</span>
                                </div>

                                @if($konsultasi->dokter)
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-user-md text-green-400 mr-2 w-4"></i>
                                    <span class="font-medium">Dokter:</span>
                                    <span class="ml-2">{{ $konsultasi->dokter }}</span>
                                </div>
                                @endif

                                <div class="flex items-center text-sm">
                                    <i class="fas fa-calendar text-purple-400 mr-2 w-4"></i>
                                    <span>{{ $konsultasi->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>

                            @if($konsultasi->jawaban)
                            <div class="mt-4 p-4 bg-slate-800/50 rounded-xl border-l-4 border-green-500">
                                <p class="text-sm text-slate-300 font-medium mb-2">
                                    <i class="fas fa-comments text-green-400 mr-2"></i>Jawaban Dokter:
                                </p>
                                <p class="text-slate-300 text-sm">{{ $konsultasi->jawaban }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('pengguna.konsultasi.show', $konsultasi->id) }}"
                       class="ml-4 bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition-all duration-300 text-sm font-medium">
                        <i class="fas fa-eye mr-2"></i> Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="glass-card rounded-2xl p-12 text-center">
                <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-comments text-slate-500 text-4xl"></i>
                </div>
                <h3 class="text-xl font-medium text-white mb-2">Belum Ada Konsultasi</h3>
                <p class="text-slate-400 mb-6">Mulai konsultasi pertama Anda dengan tenaga medis profesional</p>
                <a href="{{ route('pengguna.konsultasi.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 rounded-xl text-white font-medium transition-all duration-300">
                    <i class="fas fa-plus-circle mr-2"></i> Buat Konsultasi Baru
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <script>
        function filterKonsultasi(status) {
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('text-slate-300');
            });
            event.target.classList.add('bg-blue-600', 'text-white');
            event.target.classList.remove('text-slate-300');

            // Filter items
            const items = document.querySelectorAll('.konsultasi-item');
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
