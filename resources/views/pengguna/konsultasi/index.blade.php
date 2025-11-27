<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Konsultasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-5xl mx-auto">
    <a href="{{ route('pengguna.dashboard') }}" class="text-blue-600 underline">&larr; Kembali</a>
    <h1 class="text-2xl font-bold mt-2 mb-4">Riwayat Konsultasi</h1>

    <div class="bg-white rounded-xl shadow p-4">
        @forelse ($konsultasis as $k)
            <div class="border-b py-3">
                <p class="font-semibold">{{ $k->keluhan ?? 'Keluhan tidak ada' }}</p>
                <p class="text-sm text-gray-600">Dokter: {{ $k->dokter ?? '-' }}</p>
                <p class="text-sm text-gray-600">Tanggal: {{ $k->created_at }}</p>
            </div>
        @empty
            <p class="text-gray-500">Belum ada data konsultasi.</p>
        @endforelse
    </div>
</div>

</body>
</html>
