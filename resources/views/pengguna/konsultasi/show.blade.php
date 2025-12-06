<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konsultasi - CampusCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 19px;
            top: 48px;
            bottom: -20px;
            width: 2px;
            background: linear-gradient(to bottom, rgba(96, 165, 250, 0.5), transparent);
        }

        .timeline-item:last-child::before {
            display: none;
        }
    </style>
</head>
<body class="min-h-screen text-white bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700">
    <div class="max-w-6xl mx-auto p-6">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('pengguna.konsultasi.index') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors mb-4 group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Konsultasi
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent mb-2">
                        Detail Konsultasi #{{ $konsultasi->id }}
                    </h1>
                    <p class="text-slate-300">Status konsultasi dan informasi lengkap</p>
                </div>

                <!-- Status Badge -->
                <div class="px-6 py-3 rounded-xl font-semibold
                    @if($konsultasi->status == 'menunggu') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                    @elseif($konsultasi->status == 'diproses') bg-blue-500/20 text-blue-400 border border-blue-500/30
                    @else bg-green-500/20 text-green-400 border border-green-500/30
                    @endif">
                    <i class="fas
                        @if($konsultasi->status == 'menunggu') fa-clock
                        @elseif($konsultasi->status == 'diproses') fa-user-md
                        @else fa-check-circle
                        @endif mr-2"></i>
                    {{ ucfirst($konsultasi->status) }}
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- Keluhan Card -->
                <div class="glass-card rounded-2xl p-6">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <i class="fas fa-stethoscope text-blue-400 mr-3"></i> Keluhan Pasien
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-slate-400 block mb-1">Kategori</label>
                            <span class="inline-block px-3 py-1 bg-blue-500/20 text-blue-400 rounded-lg text-sm">
                                {{ $konsultasi->kategori ?? 'Umum' }}
                            </span>
                        </div>

                        <div>
                            <label class="text-sm text-slate-400 block mb-2">Keluhan Utama</label>
                            <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700">
                                <p class="text-white leading-relaxed">{{ $konsultasi->keluhan }}</p>
                            </div>
                        </div>

                        @if($konsultasi->gejala_tambahan)
                        <div>
                            <label class="text-sm text-slate-400 block mb-2">Gejala Tambahan</label>
                            <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700">
                                <p class="text-white leading-relaxed">{{ $konsultasi->gejala_tambahan }}</p>
                            </div>
                        </div>
                        @endif

                        @if($konsultasi->riwayat_alergi)
                        <div>
                            <label class="text-sm text-slate-400 block mb-2">
                                <i class="fas fa-allergies text-yellow-400 mr-1"></i> Riwayat Alergi
                            </label>
                            <div class="bg-yellow-500/10 rounded-xl p-4 border border-yellow-500/30">
                                <p class="text-white">{{ $konsultasi->riwayat_alergi }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center space-x-6 text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2
                                    @if($konsultasi->urgensi == 'tinggi') text-red-400
                                    @elseif($konsultasi->urgensi == 'sedang') text-yellow-400
                                    @else text-green-400
                                    @endif"></i>
                                <span class="text-slate-300">Urgensi:
                                    <span class="font-semibold
                                        @if($konsultasi->urgensi == 'tinggi') text-red-400
                                        @elseif($konsultasi->urgensi == 'sedang') text-yellow-400
                                        @else text-green-400
                                        @endif">
                                        {{ ucfirst($konsultasi->urgensi ?? 'rendah') }}
                                    </span>
                                </span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-blue-400 mr-2"></i>
                                <span class="text-slate-300">{{ $konsultasi->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jawaban Dokter Card -->
                @if($konsultasi->jawaban)
                <div class="glass-card rounded-2xl p-6 border-l-4 border-green-500">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <i class="fas fa-user-md text-green-400 mr-3"></i> Jawaban Dokter
                    </h2>

                    @if($konsultasi->dokter)
                    <div class="flex items-center mb-4 pb-4 border-b border-slate-700">
                        <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-md text-green-400 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-white">{{ $konsultasi->dokter }}</p>
                            <p class="text-sm text-slate-400">Tenaga Medis</p>
                        </div>
                    </div>
                    @endif

                    <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700">
                        <p class="text-white leading-relaxed whitespace-pre-line">{{ $konsultasi->jawaban }}</p>
                    </div>

                    @if($konsultasi->updated_at != $konsultasi->created_at)
                    <div class="mt-4 text-sm text-slate-400">
                        <i class="fas fa-clock mr-2"></i>Dijawab pada: {{ $konsultasi->updated_at->format('d M Y, H:i') }}
                    </div>
                    @endif
                </div>
                @else
                <div class="glass-card rounded-2xl p-6 text-center border-2 border-dashed border-slate-700">
                    <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-blue-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Menunggu Jawaban Dokter</h3>
                    <p class="text-slate-400 text-sm">Konsultasi Anda sedang diproses oleh tenaga medis kami</p>
                </div>
                @endif

                <!-- Rekomendasi Obat (jika ada) -->
                @if(isset($konsultasi->rekomendasi_obat) && $konsultasi->rekomendasi_obat)
                <div class="glass-card rounded-2xl p-6">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <i class="fas fa-pills text-purple-400 mr-3"></i> Rekomendasi Obat
                    </h2>
                    <div class="space-y-3">
                        @foreach(explode(',', $konsultasi->rekomendasi_obat) as $obat)
                        <div class="flex items-center bg-slate-800/50 rounded-xl p-4">
                            <i class="fas fa-capsules text-purple-400 mr-3"></i>
                            <span class="text-white">{{ trim($obat) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="md:col-span-1 space-y-6">
                <!-- Timeline Card -->
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-history text-blue-400 mr-2"></i> Timeline
                    </h3>

                    <div class="space-y-4">
                        <div class="timeline-item relative pl-10">
                            <div class="absolute left-0 top-0 w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-paper-plane text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">Konsultasi Dibuat</p>
                                <p class="text-xs text-slate-400">{{ $konsultasi->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        @if($konsultasi->status != 'menunggu')
                        <div class="timeline-item relative pl-10">
                            <div class="absolute left-0 top-0 w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-md text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">Diproses Dokter</p>
                                <p class="text-xs text-slate-400">Sedang ditangani</p>
                            </div>
                        </div>
                        @endif

                        @if($konsultasi->status == 'selesai')
                        <div class="timeline-item relative pl-10">
                            <div class="absolute left-0 top-0 w-10 h-10 bg-purple-500/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">Konsultasi Selesai</p>
                                <p class="text-xs text-slate-400">{{ $konsultasi->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Card -->
                @if($konsultasi->status == 'selesai')
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="font-semibold text-white mb-4">Tindak Lanjut</h3>
                    <div class="space-y-3">
                        <a href="{{ route('pengguna.obat.index') }}"
                           class="block text-center py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-300">
                            <i class="fas fa-pills mr-2"></i> Cari Obat
                        </a>
                        <a href="{{ route('pengguna.konsultasi.create') }}"
                           class="block text-center py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-medium transition-all duration-300">
                            <i class="fas fa-plus mr-2"></i> Konsultasi Baru
                        </a>
                    </div>
                </div>
                @endif

                <!-- Info Card -->
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center text-blue-400 mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        <h3 class="font-semibold text-white">Informasi</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-slate-300">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-400 mr-2 mt-1"></i>
                            <span>Jawaban dokter biasanya dalam 1-24 jam</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-400 mr-2 mt-1"></i>
                            <span>Data konsultasi dijaga kerahasiaannya</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-400 mr-2 mt-1"></i>
                            <span>Anda akan mendapat notifikasi saat dijawab</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
