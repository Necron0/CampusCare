@extends('mitra.layouts.app')

@section('title', 'Kelola Konsultasi')

@section('content')
<style>
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .konsultasi-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border: 1px solid #e9ecef;
        transition: all 0.2s;
    }

    .konsultasi-card:hover {
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    .badge-status {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-claim {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-claim:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 12px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #667eea; font-weight: 700;">
                <i class="fas fa-comments me-2"></i> Kelola Konsultasi
            </h2>
            <p class="text-muted mb-0">Tangani konsultasi dan berikan solusi kesehatan terbaik</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Menunggu Diklaim</p>
                        <h3 class="mb-0 fw-bold" style="color: #ffc107;">{{ $konsultasiMenunggu ?? 0 }}</h3>
                    </div>
                    <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Sedang Diproses</p>
                        <h3 class="mb-0 fw-bold" style="color: #667eea;">{{ $konsultasiDiproses ?? 0 }}</h3>
                    </div>
                    <div class="stat-icon" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                        <i class="fas fa-user-md"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Selesai</p>
                        <h3 class="mb-0 fw-bold" style="color: #28a745;">{{ $konsultasiSelesai ?? 0 }}</h3>
                    </div>
                    <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Konsultasi List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold" style="color: #667eea;">
                <i class="fas fa-list-ul me-2"></i> Daftar Konsultasi
            </h5>
        </div>
        <div class="card-body p-4">
            @forelse($konsultasis as $konsultasi)
            <div class="konsultasi-card">
                <div class="row">
                    <div class="col-md-9">
                        <!-- Status & Urgensi Badges -->
                        <div class="mb-3">
                            <span class="badge-status me-2
                                @if($konsultasi->status == 'menunggu') bg-warning text-dark
                                @elseif($konsultasi->status == 'diproses') bg-primary
                                @else bg-success
                                @endif">
                                <i class="fas
                                    @if($konsultasi->status == 'menunggu') fa-clock
                                    @elseif($konsultasi->status == 'diproses') fa-user-md
                                    @else fa-check-circle
                                    @endif me-1"></i>
                                {{ ucfirst($konsultasi->status) }}
                            </span>

                            <span class="badge-status
                                @if($konsultasi->urgensi == 'tinggi') bg-danger
                                @elseif($konsultasi->urgensi == 'sedang') bg-warning text-dark
                                @else bg-success
                                @endif">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Urgensi: {{ ucfirst($konsultasi->urgensi ?? 'rendah') }}
                            </span>
                        </div>

                        <!-- Topik & Kategori -->
                        <h5 class="fw-bold mb-2" style="color: #2c3e50;">
                            {{ $konsultasi->topik ?? 'Konsultasi #' . $konsultasi->id }}
                        </h5>

                        @if($konsultasi->kategori)
                        <span class="badge bg-light text-primary mb-3">
                            <i class="fas fa-tag me-1"></i> {{ $konsultasi->kategori }}
                        </span>
                        @endif

                        <!-- Info Pasien & Keluhan -->
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-user text-primary me-1"></i>
                                <strong>Pasien:</strong> {{ $konsultasi->user->name ?? 'Unknown' }}
                            </small>
                        </div>

                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-stethoscope text-success me-1"></i>
                                <strong>Keluhan:</strong>
                            </small>
                            <p class="mb-0 text-muted small">{{ Str::limit($konsultasi->keluhan, 150) }}</p>
                        </div>

                        @if($konsultasi->riwayat_alergi)
                        <div class="alert alert-warning py-2 mb-2" role="alert">
                            <small>
                                <i class="fas fa-allergies me-1"></i>
                                <strong>Alergi:</strong> {{ $konsultasi->riwayat_alergi }}
                            </small>
                        </div>
                        @endif

                        <small class="text-muted">
                            <i class="fas fa-calendar text-secondary me-1"></i>
                            {{ $konsultasi->created_at->format('d M Y, H:i') }}
                        </small>
                    </div>

                    <!-- Actions -->
                    <div class="col-md-3 text-end d-flex flex-column justify-content-center align-items-end">
                        @if($konsultasi->status == 'menunggu' && !$konsultasi->mitra_id)
                            <!-- Tombol Klaim -->
                            <form action="{{ route('mitra.konsultasi.claim', $konsultasi->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-claim">
                                    <i class="fas fa-hand-paper me-2"></i> Klaim Konsultasi
                                </button>
                            </form>
                            <small class="text-muted mt-2">Klik untuk menangani</small>
                        @else
                            <!-- Tombol Detail -->
                            <a href="{{ route('mitra.konsultasi.show', $konsultasi->id) }}" class="btn btn-gradient">
                                <i class="fas fa-eye me-2"></i> Lihat Detail
                            </a>
                            @if($konsultasi->status == 'diproses')
                            <small class="text-success mt-2">
                                <i class="fas fa-check me-1"></i> Anda menangani ini
                            </small>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h5 class="fw-bold mb-2">Tidak Ada Konsultasi</h5>
                <p class="text-muted mb-0">Belum ada konsultasi yang perlu ditangani saat ini</p>
            </div>
            @endforelse

            <!-- Pagination -->
            @if($konsultasis->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $konsultasis->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
