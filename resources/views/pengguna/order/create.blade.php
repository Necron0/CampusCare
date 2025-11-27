<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Obat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">
    <a href="{{ route('pengguna.obat.index') }}" class="text-blue-600 underline">&larr; Kembali</a>

    <h1 class="text-2xl font-bold mt-3 mb-4">Pesan Obat</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-4 p-4 bg-gray-50 rounded">
        <p class="font-semibold">{{ $obat->nama }}</p>
        <p class="text-sm text-gray-600">Kategori: {{ $obat->kategori }}</p>
        <p class="text-sm text-gray-600">Harga: Rp {{ number_format($obat->harga) }}</p>
        <p class="text-sm text-gray-600">Stok tersedia: {{ $obat->stok }}</p>
    </div>

    <form method="POST" action="{{ route('pengguna.order.store', $obat->id) }}" class="space-y-3">
        @csrf

        <input type="text" name="nama_penerima" placeholder="Nama Penerima" required
               class="w-full p-2 border rounded">

        <input type="text" name="no_hp" placeholder="No HP" required
               class="w-full p-2 border rounded">

        <textarea name="alamat" placeholder="Alamat Lengkap Pengantaran" required
                  class="w-full p-2 border rounded"></textarea>

        <select name="opsi_pengiriman" required class="w-full p-2 border rounded">
            <option value="">-- Pilih Opsi Pengiriman --</option>
            <option value="instant">Instant (Rp15.000)</option>
            <option value="reguler">Reguler (Rp8.000)</option>
            <option value="pickup">Ambil di Apotek (Gratis)</option>
        </select>

        <input type="number" name="qty" min="1" value="1" required
               class="w-full p-2 border rounded">

        <button class="w-full bg-green-600 text-white p-2 rounded">
            Buat Pesanan
        </button>
    </form>
</div>

</body>
</html>


