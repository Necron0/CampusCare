<!doctype html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard Pengguna - CampusCare</title>
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

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .quick-action-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .quick-action-card::after {
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

        .quick-action-card:hover::after {
            transform: scaleX(1);
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes floating {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        @keyframes pulseGlow {
            from { box-shadow: 0 0 20px rgba(96, 165, 250, 0.3); }
            to { box-shadow: 0 0 30px rgba(96, 165, 250, 0.6); }
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
        .animate-delay-500 { animation-delay: 0.5s; }
        .animate-delay-600 { animation-delay: 0.6s; }
    </style>
</head>
<body class="h-full gradient-bg overflow-x-hidden">
    <div class="relative z-10 min-h-screen">
        <div class="max-w-7xl mx-auto p-6">
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 animate-slide-in-up">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-4xl font-bold gradient-text">Selamat Datang, <span class="text-white">{{ $user->name }}</span>! 👋</h1>
                    <p class="text-slate-300 mt-2">Ini adalah ringkasan aktivitas kesehatan Anda di CampusCare</p>
                </div>

                <!-- User Info dan Logout Section -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3 bg-slate-800/50 backdrop-blur-sm rounded-2xl px-4 py-3 border border-slate-700/50">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-white font-medium">{{ $user->name }}</div>
                            <div class="text-slate-400 text-xs">Pengguna Aktif</div>
                        </div>
                    </div>

                    <!-- Tombol Logout -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>

                    <button onclick="confirmLogout()"
                            class="group relative flex items-center justify-center w-12 h-12 bg-gradient-to-br from-red-500/20 to-pink-500/20 hover:from-red-600/30 hover:to-pink-600/30 rounded-2xl border border-red-500/30 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-red-500/10"
                            title="Keluar dari akun">
                        <svg class="w-6 h-6 text-red-400 group-hover:text-red-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>

                        <!-- Tooltip -->
                        <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                            Keluar
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 rotate-45 w-2 h-2 bg-slate-800"></div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Obat Card -->
                <div class="stat-card glass-card rounded-2xl p-6 hover-lift animate-slide-in-up">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-slate-300 text-sm font-medium">Total Obat Tersedia</div>
                        <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center floating">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">{{ $totalObat ?? 0 }}</div>
                    <div class="text-slate-400 text-sm">Obat tersedia untuk Anda</div>
                    <div class="mt-3 w-full bg-slate-700 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>

                <!-- Total Konsultasi Card -->
                <div class="stat-card glass-card rounded-2xl p-6 hover-lift animate-slide-in-up animate-delay-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-slate-300 text-sm font-medium">Total Konsultasi</div>
                        <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center floating">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">{{ $totalKonsultasi ?? 0 }}</div>
                    <div class="text-slate-400 text-sm">Sesi konsultasi kesehatan</div>
                    <div class="mt-3 w-full bg-slate-700 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                </div>

                <!-- Riwayat Pembelian Card -->
                <div class="stat-card glass-card rounded-2xl p-6 hover-lift animate-slide-in-up animate-delay-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-slate-300 text-sm font-medium">Riwayat Pembelian</div>
                        <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center floating">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">{{ $totalOrder ?? 0 }}</div>
                    <div class="text-slate-400 text-sm">Order yang telah dibuat</div>
                    <div class="mt-3 w-full bg-slate-700 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <a href="{{ route('pengguna.obat.index') }}" class="quick-action-card glass-card rounded-2xl p-6 hover-lift group pulse-glow animate-slide-in-up animate-delay-300">
                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white mb-2">Lihat Obat</h3>
                            <p class="text-slate-300 text-sm">Cari obat berdasarkan gejala, kategori, atau lokasi terdekat</p>
                            <div class="flex items-center mt-3 text-blue-400 text-sm font-medium">
                                <span>Jelajahi Katalog</span>
                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('pengguna.konsultasi.index') }}" class="quick-action-card glass-card rounded-2xl p-6 hover-lift group animate-slide-in-up animate-delay-400">
                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white mb-2">Konsultasi</h3>
                            <p class="text-slate-300 text-sm">Konsultasi kesehatan dengan tenaga medis profesional</p>
                            <div class="flex items-center mt-3 text-green-400 text-sm font-medium">
                                <span>Mulai Konsultasi</span>
                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('pengguna.riwayat.index') }}" class="quick-action-card glass-card rounded-2xl p-6 hover-lift group animate-slide-in-up animate-delay-500">
                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white mb-2">Riwayat Pembelian</h3>
                            <p class="text-slate-300 text-sm">Lihat history pembelian obat dan status pengiriman</p>
                            <div class="flex items-center mt-3 text-purple-400 text-sm font-medium">
                                <span>Cek Riwayat</span>
                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recent History Section -->
            <div class="glass-card rounded-2xl p-6 animate-slide-in-up animate-delay-600">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-white">Riwayat Terakhir</h2>
                    <div class="flex items-center text-slate-400 text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Updated just now
                    </div>
                </div>

                @php
                    $ordersToDisplay = $formattedOrders ?? [];
                @endphp

                @if(empty($ordersToDisplay))
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">Belum ada pembelian</h3>
                        <p class="text-slate-400 text-sm">Mulai jelajahi obat-obatan yang tersedia</p>
                        <a href="{{ route('pengguna.obat.index') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Belanja Sekarang
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($ordersToDisplay as $o)
                            <div class="flex items-center justify-between p-4 bg-slate-800/30 rounded-xl border border-slate-700/50 hover:bg-slate-800/50 transition-colors group">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-white group-hover:text-blue-300 transition-colors">
                                            {{ $o['nama'] }} <span class="text-slate-400">x{{ $o['qty'] }}</span>
                                        </div>
                                        <div class="text-xs text-slate-400 flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $o['waktu'] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-white">Rp {{ number_format($o['total'],0,',','.') }}</div>
                                    <div class="text-xs text-green-400 font-medium mt-1">Completed</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('pengguna.riwayat.index') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">
                            Lihat semua riwayat
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div id="logout-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="glass-card rounded-2xl p-6 max-w-md w-full mx-4 transform scale-95 animate-slide-in-up">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500/20 to-pink-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Keluar dari Akun?</h3>
                <p class="text-slate-300">Anda akan keluar dari dashboard CampusCare. Yakin ingin melanjutkan?</p>
            </div>

            <div class="flex space-x-3">
                <button onclick="hideLogoutModal()"
                        class="flex-1 py-3 px-4 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-medium transition-colors">
                    Batal
                </button>
                <button onclick="performLogout()"
                        class="flex-1 py-3 px-4 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white rounded-xl font-medium transition-all">
                    Ya, Keluar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Add staggered animation to stat cards
        document.addEventListener('DOMContentLoaded', function() {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // Logout Functions
        function confirmLogout() {
            const modal = document.getElementById('logout-modal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideLogoutModal() {
            const modal = document.getElementById('logout-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function performLogout() {
            document.getElementById('logout-form').submit();
        }

        // Close modal when clicking outside
        document.getElementById('logout-modal').addEventListener('click', function(e) {
            if (e.target.id === 'logout-modal') {
                hideLogoutModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideLogoutModal();
            }
        });
    </script>
</body>
</html>
