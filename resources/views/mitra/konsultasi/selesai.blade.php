@extends('mitra.layouts.app')

@section('title', 'Riwayat Konsultasi Selesai')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-dark">
                        <i class="fas fa-history text-primary"></i> Riwayat Konsultasi Selesai
                    </h2>
                    <p class="text-muted">Konsultasi yang sudah Anda tangani</p>
                </div>
                <a href="{{ route('mitra.konsultasi.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Konsultasi Aktif
                </a>
            </div>
        </div>
    </div>

    @if($konsultasis->count() > 0)
        <div class="row">
            @foreach($konsultasis as $konsultasi)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-success text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">#{{ $konsultasi->id }}</span>
                                <small>{{ $konsultasi->dijawab_pada->format('d/m/Y') }}</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="fw-bold">{{ $konsultasi->kategori ?? 'Konsultasi Umum' }}</h6>
                            <p class="small text-muted mb-2">{{ Str::limit($konsultasi->keluhan, 80) }}</p>

                            <div class="mb-3">
                                <small class="text-muted">Pasien:</small>
                                <p class="mb-1 fw-bold">{{ $konsultasi->user->name ?? 'Anonim' }}</p>
                            </div>

                            @if($konsultasi->rekomendasi_obat)
                                <div class="mb-3">
                                    <small class="text-muted">Obat yang direkomendasikan:</small>
                                    <p class="mb-1 fw-bold text-success">{{ $konsultasi->rekomendasi_obat }}</p>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('konsultasi.show', $konsultasi->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                                <span class="badge bg-light text-dark">
                                    <i class="far fa-clock"></i> {{ $konsultasi->dijawab_pada->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $konsultasis->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-history fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada riwayat konsultasi</h4>
            <p class="text-muted">Mulai tangani konsultasi dari menu utama</p>
            <a href="{{ route('mitra.konsultasi.index') }}" class="btn btn-primary mt-2">
                <i class="fas fa-arrow-right"></i> Lihat Konsultasi Aktif
            </a>
        </div>
    @endif
</div>
@endsection
