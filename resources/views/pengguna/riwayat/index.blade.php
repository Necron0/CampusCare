<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembelian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-5xl mx-auto">
    <a href="{{ route('pengguna.dashboard') }}" class="text-blue-600 underline">&larr; Kembali</a>
    <h1 class="text-2xl font-bold mt-3 mb-4">Riwayat Pembelian</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-4">
        @forelse($orders as $order)
            <div class="border-b py-3">
                <p class="font-semibold">Order #{{ $order->id }}</p>
                <p class="text-sm text-gray-600">Penerima: {{ $order->nama_penerima }} ({{ $order->no_hp }})</p>
                <p class="text-sm text-gray-600">Alamat: {{ $order->alamat }}</p>
                <p class="text-sm text-gray-600">Pengiriman: {{ $order->opsi_pengiriman }} | Ongkir: Rp{{ number_format($order->ongkir) }}</p>
                <p class="text-sm text-gray-600">Status: {{ $order->status }}</p>

                <ul class="list-disc ml-6 mt-2">
                    @foreach($order->items as $item)
                        <li>
                            {{ $item->obat->nama }} x{{ $item->qty }}
                            (Rp{{ number_format($item->subtotal) }})
                        </li>
                    @endforeach
                </ul>

                <p class="font-bold mt-2">Total: Rp{{ number_format($order->total_harga) }}</p>
            </div>
        @empty
            <p class="text-gray-500">Belum ada pesanan.</p>
        @endforelse
    </div>
</div>

</body>
</html>


</body>
</html>






