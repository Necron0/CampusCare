<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CampusCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-1">Dashboard CampusCare</h1>
    <p class="text-gray-600 mb-6">Halo, {{ $user->name }} 👋</p>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Total Obat</p>
            <p class="text-4xl font-bold mt-2">{{ $totalObat }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Total Konsultasi</p>
            <p class="text-4xl font-bold mt-2">{{ $totalKonsultasi }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Riwayat Pembelian</p>
            <p class="text-4xl font-bold mt-2">{{ $totalOrder }}</p>
        </div>
    </div>

    {{-- Menu --}}
    <h2 class="text-xl font-semibold mt-8 mb-3">Menu Layanan</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('pengguna.obat.index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white p-5 rounded-xl shadow transition">
            <h3 class="text-lg font-bold">Lihat Obat</h3>
            <p class="text-sm opacity-90 mt-1">Cari obat & lihat detailnya</p>
        </a>

        <a href="{{ route('pengguna.konsultasi.index') }}"
           class="bg-green-600 hover:bg-green-700 text-white p-5 rounded-xl shadow transition">
            <h3 class="text-lg font-bold">Konsultasi</h3>
            <p class="text-sm opacity-90 mt-1">Riwayat konsultasi kesehatan</p>
        </a>

        <a href="{{ route('pengguna.riwayat.index') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white p-5 rounded-xl shadow transition">
            <h3 class="text-lg font-bold">Riwayat Pembelian</h3>
            <p class="text-sm opacity-90 mt-1">Belum aktif (dummy)</p>
        </a>
    </div>
</div>

</body>
</html>



