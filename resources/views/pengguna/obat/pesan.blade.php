<!doctype html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Obat - CampusCare</title>
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
    </style>
</head>
<body class="h-full gradient-bg overflow-x-hidden">
    <div class="relative z-10 min-h-screen">
        <div class="max-w-4xl mx-auto p-6">
            <!-- Navigation -->
            <div class="mb-8 animate-slide-in-up">
                <a href="{{ route('pengguna.obat.show', $obat->id) }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Detail Obat
                </a>
            </div>

            <!-- Main Card -->
            <div class="glass-card rounded-2xl p-8 mb-8 animate-slide-in-up animate-delay-100">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold gradient-text mb-2">
                        <i class="fas fa-shopping-cart mr-2"></i> Pemesanan Obat
                    </h1>
                    <p class="text-slate-300">Lengkapi form di bawah untuk melanjutkan pesanan</p>
                </div>

                <!-- Obat Info Card -->
                <div class="bg-slate-800/50 rounded-xl p-6 mb-6 border border-slate-700/50">
                    <div class="flex items-start space-x-4">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-pills text-blue-400 text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $obat->nama_obat }}</h3>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div class="flex items-center text-slate-300">
                                    <i class="fas fa-tag text-green-400 mr-2"></i>
                                    <span>Rp {{ number_format($obat->harga, 0, ',', '.') }}/{{ $obat->satuan ?? 'pcs' }}</span>
                                </div>
                                <div class="flex items-center text-slate-300">
                                    <i class="fas fa-boxes text-blue-400 mr-2"></i>
                                    <span>Stok: {{ $obat->stok }}</span>
                                </div>
                                <div class="flex items-center text-slate-300">
                                    <i class="fas fa-store text-purple-400 mr-2"></i>
                                    <span>{{ $obat->mitra->nama_apotek ?? 'Apotek' }}</span>
                                </div>
                                <div class="flex items-center text-slate-300">
                                    <i class="fas fa-map-marker-alt text-red-400 mr-2"></i>
                                    <span>{{ $obat->lokasi_apotek ?? 'Kampus' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('pengguna.obat.pesan.store', $obat->id) }}" class="space-y-6">
                    @csrf

                    <!-- Jumlah -->
                    <div>
                        <label class="block text-slate-300 font-medium mb-2">
                            <i class="fas fa-calculator text-blue-400 mr-2"></i>
                            Jumlah Pesanan
                        </label>
                        <div class="relative">
                            <input type="number"
                                   name="qty"
                                   min="1"
                                   max="{{ $obat->stok }}"
                                   value="1"
                                   id="qty"
                                   class="w-full bg-slate-800/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                   placeholder="Masukkan jumlah"
                                   oninput="calculateTotal()">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">
                                Max: {{ $obat->stok }}
                            </span>
                        </div>
                        @error('qty')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Harga -->
                    <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-xl p-4 border border-blue-500/20">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-300 font-medium">
                                <i class="fas fa-receipt text-blue-400 mr-2"></i>
                                Total Harga
                            </span>
                            <span class="text-2xl font-bold text-white" id="totalPrice">
                                Rp {{ number_format($obat->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div>
                        <label class="block text-slate-300 font-medium mb-2">
                            <i class="fas fa-map-marker-alt text-red-400 mr-2"></i>
                            Alamat Pengiriman
                        </label>
                        <textarea name="alamat"
                                  rows="4"
                                  class="w-full bg-slate-800/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                                  placeholder="Contoh: Asrama Mahasiswa Blok A No. 12, Kampus Universitas XYZ"
                                  required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-slate-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pastikan alamat lengkap dan mudah ditemukan
                        </p>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label class="block text-slate-300 font-medium mb-2">
                            <i class="fas fa-comment-dots text-yellow-400 mr-2"></i>
                            Catatan (Opsional)
                        </label>
                        <textarea name="catatan"
                                  rows="3"
                                  class="w-full bg-slate-800/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                                  placeholder="Contoh: Tolong hubungi saya sebelum diantar, Obat untuk keperluan mendesak, dll.">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex space-x-3 pt-4">
                        <a href="{{ route('pengguna.obat.show', $obat->id) }}"
                           class="flex-1 bg-slate-700/50 hover:bg-slate-600 text-white py-4 text-center rounded-xl font-semibold transition-all duration-300">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        <button type="submit"
                                class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg shadow-green-500/20">
                            <i class="fas fa-check-circle mr-2"></i> Konfirmasi Pesanan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Cards -->
                <div class="glass-card rounded-xl p-4 text-center">
                    <i class="fas fa-shield-alt text-green-400 text-2xl mb-2"></i>
                    <h4 class="font-semibold text-white text-sm mb-1">Obat Terjamin</h4>
                    <p class="text-slate-400 text-xs">100% original & aman</p>
                </div>
                <div class="glass-card rounded-xl p-4 text-center">
                    <i class="fas fa-headset text-purple-400 text-2xl mb-2"></i>
                    <h4 class="font-semibold text-white text-sm mb-1">CS Siap Membantu</h4>
                    <p class="text-slate-400 text-xs">Hubungi kami kapan saja</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const hargaSatuan = {{ $obat->harga }};

        function calculateTotal() {
            const qty = document.getElementById('qty').value || 1;
            const total = qty * hargaSatuan;
            document.getElementById('totalPrice').textContent =
                'Rp ' + total.toLocaleString('id-ID');
        }

        // Initialize
        calculateTotal();
    </script>
</body>
</html>
