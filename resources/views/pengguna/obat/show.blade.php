<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Detail Obat</title>
</head>
<body class="bg-slate-950 text-white min-h-screen">
    <div class="max-w-3xl mx-auto p-6">
        <a href="{{ route('pengguna.obat.index') }}" class="text-sm text-slate-300 hover:text-white">← Kembali</a>

        <div class="bg-slate-900 p-6 rounded-xl mt-4">
            <h1 class="text-2xl font-bold">{{ $obat->nama }}</h1>
            <div class="text-slate-300 mt-2">{{ $obat->kategori }} • {{ $obat->gejala }}</div>
            <div class="text-slate-400 mt-1">{{ $obat->lokasi_apotek }}</div>

            <div class="mt-4 text-sm leading-relaxed text-slate-200">
                {{ $obat->deskripsi }}
            </div>

            <div class="mt-4 font-bold text-lg">
                Rp {{ number_format($obat->harga,0,',','.') }}
            </div>
            <div class="text-sm text-slate-400 mt-1">Stok: {{ $obat->stok }}</div>

            <a href="{{ route('pengguna.obat.pesan', $obat->id) }}" class="inline-block mt-5 bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-sm">
                Pesan Sekarang
            </a>
        </div>
    </div>
</body>
</html>
