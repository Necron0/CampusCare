@extends('admin.layouts.app')

@section('title', 'Dashboard Admin - CampusCare')

@section('content')

<main class="p-6 sm:p-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-600 mt-1">Selamat datang di panel admin CampusCare</p>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="p-6 bg-amber-400 text-white rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm font-medium opacity-90">Total User</div>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="text-4xl font-bold">{{ $totalUsers }}</div>
        </div>


        <div class="p-6 bg-amber-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm font-medium opacity-90">Admin</div>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div class="text-4xl font-bold">{{ $totalAdmins }}</div>
        </div>

        <div class="p-6 bg-amber-800 text-white rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm font-medium opacity-90">Mitra</div>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="text-4xl font-bold">{{ $totalMitra }}</div>
        </div>

        <div class="p-6 bg-red-900 text-white rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm font-medium opacity-90">Mahasiswa</div>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
            <div class="text-4xl font-bold">{{ $totalMahasiswa }}</div>
        </div>

        <div class="p-6 bg-blue-800 text-white rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm font-medium opacity-90">Transaksi</div>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="text-4xl font-bold">{{ $totalTransaksi ?? 0 }}</div>
        </div>

        <div class="p-6 bg-amber-500 text-white rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm font-medium opacity-90">Konsultasi</div>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <div class="text-4xl font-bold">{{ $totalKonsultasi ?? 0 }}</div>
        </div>

    </div>

    @yield('additional-content')

</main>

@endsection

@section('scripts')
<script>
    console.log('Dashboard loaded');
</script>
@endsection
