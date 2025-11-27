<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Dashboard Pengguna</title>
</head>
<body class="bg-slate-950 text-white min-h-screen">
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Halo, {{ $user->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-slate-900 p-5 rounded-xl">
                <div class="text-sm text-slate-300">Total Obat</div>
                <div class="text-3xl font-bold mt-2">{{ $totalObat }}</div>
            </div>
            <div class="bg-slate-900 p-5 rounded-xl">
                <div class="text-sm text-slate-300">Total Konsultasi</div>
                <div class="text-3xl font-bold mt-2">{{ $totalKonsultasi }}</div>
            </div>
            <div class="bg-slate-900 p-5 rounded-xl">
                <div class="text-sm text-slate-300">Riwayat Pembelian</div>
                <div class="text-3xl font-bold mt-2">{{ $totalOrder }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
            <a href="{{ route('pengguna.obat.index') }}" class="bg-blue-600 hover:bg-blue-700 p-5 rounded-xl block">
                <h3 class="text-lg font-bold">Lihat Obat</h3>
                <p class="text-sm opacity-90 mt-1">Cari obat berdasarkan gejala/kategori/lokasi</p>
            </a>
            <a href="{{ route('pengguna.konsultasi.index') }}" class="bg-green-600 hover:bg-green-700 p-5 rounded-xl block">
                <h3 class="text-lg font-bold">Konsultasi</h3>
                <p class="text-sm opacity-90 mt-1">Riwayat konsultasi kesehatan</p>
            </a>
            <a href="{{ route('pengguna.riwayat.index') }}" class="bg-purple-600 hover:bg-purple-700 p-5 rounded-xl block">
                <h3 class="text-lg font-bold">Riwayat Pembelian</h3>
                <p class="text-sm opacity-90 mt-1">Lihat order obat yang pernah dibuat</p>
            </a>
        </div>

        <h2 class="text-xl font-bold mb-3">Riwayat Terakhir</h2>
        <div class="bg-slate-900 rounded-xl p-4">
            @if(count($orders) == 0)
                <div class="text-slate-300 text-sm">Belum ada pembelian.</div>
            @else
                <div class="space-y-3">
                    @foreach(array_reverse($orders) as $o)
                        <div class="flex justify-between items-center border-b border-slate-800 pb-2">
                            <div>
                                <div class="font-semibold">{{ $o['nama'] }} x{{ $o['qty'] }}</div>
                                <div class="text-xs text-slate-400">{{ $o['waktu'] }}</div>
                            </div>
                            <div class="font-bold">Rp {{ number_format($o['total'],0,',','.') }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>
</html>

