@extends('admin.layouts.app')

@section('title', 'Dashboard Admin - CampusCare')

@section('content')

<main class="p-6 sm:p-8 bg-gray-50 min-h-screen">

    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
                <p class="text-gray-600 mt-1">Selamat datang di panel admin CampusCare</p>
            </div>
            <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg shadow-sm border">
                <span class="font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group overflow-hidden">
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-sm font-medium opacity-90">Total User</div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold mb-2">{{ $totalUsers }}</div>
                <div class="text-xs opacity-80">Semua pengguna sistem</div>
            </div>
            <div class="h-1 bg-gradient-to-r from-white to-transparent opacity-20"></div>
        </div>

        <!-- Admin Card -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group overflow-hidden">
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-sm font-medium opacity-90">Administrator</div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold mb-2">{{ $totalAdmins }}</div>
                <div class="text-xs opacity-80">Pengelola sistem</div>
            </div>
            <div class="h-1 bg-gradient-to-r from-white to-transparent opacity-20"></div>
        </div>

        <!-- Mitra Card -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 text-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group overflow-hidden">
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-sm font-medium opacity-90">Mitra Kampus</div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold mb-2">{{ $totalMitra }}</div>
                <div class="text-xs opacity-80">Partner kampus</div>
            </div>
            <div class="h-1 bg-gradient-to-r from-white to-transparent opacity-20"></div>
        </div>

        <!-- Mahasiswa Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group overflow-hidden">
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-sm font-medium opacity-90">Mahasiswa</div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold mb-2">{{ $totalMahasiswa }}</div>
                <div class="text-xs opacity-80">Pengguna aktif</div>
            </div>
            <div class="h-1 bg-gradient-to-r from-white to-transparent opacity-20"></div>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Transaksi Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Transaksi</h3>
                        <p class="text-sm text-gray-600">Total order mahasiswa</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold text-gray-800 mb-2">{{ $totalTransaksi ?? 0 }}</div>
                <div class="flex items-center text-sm text-green-600 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    Semua transaksi sistem
                </div>
            </div>
        </div>

        <!-- Konsultasi Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Konsultasi</h3>
                        <p class="text-sm text-gray-600">Sesi konsultasi mahasiswa</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center text-white">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold text-gray-800 mb-2">{{ $totalKonsultasi ?? 0 }}</div>
                <div class="flex items-center text-sm text-blue-600 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Layanan konsultasi aktif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Actions -->
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.user-management.index') }}" class="flex items-center p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors group">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-800">Kelola User</div>
                        <div class="text-sm text-gray-600">Manajemen pengguna</div>
                    </div>
                </a>

                <a href="#" class="flex items-center p-3 bg-green-50 rounded-xl hover:bg-green-100 transition-colors group">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-800">Laporan</div>
                        <div class="text-sm text-gray-600">Statistik & analisis</div>
                    </div>
                </a>

                <a href="#" class="flex items-center p-3 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors group">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-800">Pengaturan</div>
                        <div class="text-sm text-gray-600">Konfigurasi sistem</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Statistics Chart -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Pengguna</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-xl">
                    <div class="text-2xl font-bold text-blue-600">{{ $totalAdmins }}</div>
                    <div class="text-sm text-gray-600">Admin</div>
                    <div class="mt-2 w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $totalUsers > 0 ? ($totalAdmins/$totalUsers)*100 : 0 }}%"></div>
                    </div>
                </div>
                <div class="text-center p-4 bg-amber-50 rounded-xl">
                    <div class="text-2xl font-bold text-amber-600">{{ $totalMitra }}</div>
                    <div class="text-sm text-gray-600">Mitra</div>
                    <div class="mt-2 w-full bg-amber-200 rounded-full h-2">
                        <div class="bg-amber-600 h-2 rounded-full" style="width: {{ $totalUsers > 0 ? ($totalMitra/$totalUsers)*100 : 0 }}%"></div>
                    </div>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-xl">
                    <div class="text-2xl font-bold text-purple-600">{{ $totalMahasiswa }}</div>
                    <div class="text-sm text-gray-600">Mahasiswa</div>
                    <div class="mt-2 w-full bg-purple-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $totalUsers > 0 ? ($totalMahasiswa/$totalUsers)*100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

@endsection

@section('scripts')
<script>
    console.log('Dashboard CampusCare loaded successfully');

    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.bg-gradient-to-br, .bg-white');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';

            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endsection
