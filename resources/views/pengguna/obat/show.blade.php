<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Obat - CampusCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'pulse-glow': 'pulseGlow 2s ease-in-out infinite alternate',
                    },
                    keyframes: {
                        pulseGlow: {
                            'from': { 'box-shadow': '0 0 20px rgba(96, 165, 250, 0.3)' },
                            'to': { 'box-shadow': '0 0 30px rgba(96, 165, 250, 0.6)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="text-white bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 min-h-screen">
    <div class="max-w-4xl mx-auto p-6">
        <!-- Navigation -->
        <a href="{{ route('pengguna.obat.index') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors mb-6 group">
            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Katalog
        </a>

        <!-- Main Card -->
        <div class="glass-card rounded-2xl p-8 transition-all duration-300 hover:shadow-xl">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Left Column - Image & Basic Info -->
                <div>
                    <div class="w-full h-64 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-capsules text-blue-400 text-8xl"></i>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center p-4 bg-slate-800/50 rounded-xl transition-all duration-300 hover:bg-slate-800/70">
                            <i class="fas fa-tag text-green-400 text-xl mb-2"></i>
                            <div class="text-white font-bold text-lg">Rp {{ number_format($obat->harga,0,',','.') }}</div>
                            <div class="text-slate-400 text-sm">Harga</div>
                        </div>
                        <div class="text-center p-4 bg-slate-800/50 rounded-xl transition-all duration-300 hover:bg-slate-800/70">
                            <i class="fas fa-boxes text-blue-400 text-xl mb-2"></i>
                            <div class="text-white font-bold text-lg">{{ $obat->stok }}</div>
                            <div class="text-slate-400 text-sm">Stok Tersedia</div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Details -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">{{ $obat->nama }}</h1>
                        <span class="bg-blue-500/20 text-blue-400 text-sm px-3 py-1 rounded-full">
                            {{ $obat->kategori ?? 'Umum' }}
                        </span>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="flex items-center text-slate-300">
                            <i class="fas fa-stethoscope text-purple-400 mr-3 transition-transform duration-300 hover:scale-110"></i>
                            <div>
                                <div class="text-sm text-slate-400">Gejala</div>
                                <div class="font-medium">{{ $obat->gejala ?? 'Berbagai gejala' }}</div>
                            </div>
                        </div>
                        <div class="flex items-center text-slate-300">
                            <i class="fas fa-map-marker-alt text-red-400 mr-3 transition-transform duration-300 hover:scale-110"></i>
                            <div>
                                <div class="text-sm text-slate-400">Lokasi</div>
                                <div class="font-medium">{{ $obat->lokasi_apotek ?? 'Apotek Kampus' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-3 flex items-center">
                            <i class="fas fa-file-medical text-blue-400 mr-2"></i> Deskripsi Obat
                        </h3>
                        <p class="text-slate-300 leading-relaxed bg-slate-800/30 p-4 rounded-xl">
                            {{ $obat->deskripsi ?? 'Obat ini digunakan untuk mengatasi berbagai keluhan kesehatan dengan efektif dan aman.' }}
                        </p>
                    </div>

                    <!-- Action Button -->
                    <div class="flex space-x-4">
                        <a href="{{ route('pengguna.obat.pesan', $obat->id) }}"
                           class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-4 rounded-xl text-center font-semibold transition-all duration-300 animate-pulse-glow flex items-center justify-center hover:scale-105">
                            <i class="fas fa-shopping-cart mr-3"></i> Pesan Sekarang
                        </a>
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-6 p-4 bg-slate-800/30 rounded-xl transition-all duration-300 hover:bg-slate-800/40">
                        <div class="flex items-center text-slate-400 text-sm">
                            <i class="fas fa-info-circle text-yellow-400 mr-2"></i>
                            Pastikan untuk membaca aturan pakai dan konsultasi dengan tenaga medis jika diperlukan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="glass-card rounded-2xl p-6 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <i class="fas fa-shield-alt text-green-400 text-3xl mb-4 transition-transform duration-300 hover:scale-110"></i>
                <h3 class="font-semibold text-white mb-2">Terjamin Keasliannya</h3>
                <p class="text-slate-300 text-sm">Obat berasal dari supplier terpercaya</p>
            </div>
            <div class="glass-card rounded-2xl p-6 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <i class="fas fa-truck-fast text-blue-400 text-3xl mb-4 transition-transform duration-300 hover:scale-110"></i>
                <h3 class="font-semibold text-white mb-2">Pengiriman Cepat</h3>
                <p class="text-slate-300 text-sm">Sampai dalam waktu 1-2 jam</p>
            </div>
            <div class="glass-card rounded-2xl p-6 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <i class="fas fa-headset text-purple-400 text-3xl mb-4 transition-transform duration-300 hover:scale-110"></i>
                <h3 class="font-semibold text-white mb-2">Dukungan 24/7</h3>
                <p class="text-slate-300 text-sm">Tim medis siap membantu Anda</p>
            </div>
        </div>
    </div>
</body>
</html>
