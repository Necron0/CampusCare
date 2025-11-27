<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Pemesanan Obat</title>
</head>
<body class="bg-slate-950 text-white min-h-screen">
    <div class="max-w-3xl mx-auto p-6">
        <a href="{{ route('pengguna.obat.show', $obat->id) }}" class="text-sm text-slate-300 hover:text-white">← Kembali</a>

        <div class="bg-slate-900 p-6 rounded-xl mt-4">
            <h1 class="text-xl font-bold mb-4">Pesan: {{ $obat->nama }}</h1>

            <form method="POST" action="{{ route('pengguna.obat.pesan.store', $obat->id) }}" class="space-y-3">
                @csrf

                <div>
                    <label class="text-sm text-slate-300">Jumlah</label>
                    <input type="number" name="qty" min="1" value="1" class="w-full bg-slate-800 rounded-lg px-3 py-2 text-sm outline-none mt-1">
                </div>

                <div>
                    <label class="text-sm text-slate-300">Alamat Pengiriman</label>
                    <textarea name="alamat" rows="3" class="w-full bg-slate-800 rounded-lg px-3 py-2 text-sm outline-none mt-1"></textarea>
                </div>

                <div>
                    <label class="text-sm text-slate-300">Catatan (opsional)</label>
                    <input name="catatan" class="w-full bg-slate-800 rounded-lg px-3 py-2 text-sm outline-none mt-1">
                </div>

                <button class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-sm">
                    Konfirmasi Pesanan
                </button>
            </form>
        </div>
    </div>
</body>
</html>
