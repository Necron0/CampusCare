<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Obat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-5xl mx-auto">
    <a href="{{ route('pengguna.dashboard') }}" class="text-blue-600 underline">&larr; Kembali</a>
    <h1 class="text-2xl font-bold mt-2 mb-4">Daftar Obat</h1>

    <form method="GET" class="bg-white p-4 rounded-xl shadow mb-4 grid md:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Cari nama / gejala / kategori..."
               class="p-2 rounded border w-full md:col-span-4">

        <div class="flex gap-2 md:col-span-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded w-full">Terapkan</button>
            <a href="{{ route('pengguna.obat.index') }}"
               class="bg-gray-300 text-black px-4 py-2 rounded w-full text-center">Reset</a>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow p-4">
        @forelse ($obats as $obat)
            <div class="border-b py-3 flex justify-between items-center">
                <div>
                    <p class="font-semibold text-lg">{{ $obat->nama }}</p>
                    <p class="text-sm text-gray-600">
                        Kategori: {{ $obat->kategori ?? '-' }} |
                        Gejala: {{ $obat->gejala ?? '-' }}
                    </p>
                    <p class="text-sm text-gray-600">
                        Lokasi: {{ $obat->lokasi_apotek ?? '-' }}
                    </p>
                </div>

                <div class="text-right">
                    <p class="font-bold text-green-700">
                        Rp {{ number_format($obat->harga) }}
                    </p>
                    <p class="text-sm mb-2">Stok: {{ $obat->stok }}</p>

                    <a href="{{ route('pengguna.order.create', $obat->id) }}"
                       class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                        Pesan
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Obat tidak ditemukan.</p>
        @endforelse

        @if(method_exists($obats, 'links'))
            <div class="mt-4">
                {{ $obats->links() }}
            </div>
        @endif
    </div>
</div>

</body>
</html>

