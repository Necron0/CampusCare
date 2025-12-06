@extends('mitra.layouts.app')

@section('title', 'Detail Konsultasi')

@section('content')
<style>
    .detail-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
    }

    .info-label {
        color: #6c757d;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .info-value {
        color: #2c3e50;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .timeline-item {
        position: relative;
        padding-left: 3rem;
        padding-bottom: 2rem;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 18px;
        top: 30px;
        width: 2px;
        height: calc(100% - 30px);
        background: linear-gradient(to bottom, rgba(102, 126, 234, 0.3), transparent);
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <a href="{{ route('mitra.konsultasi.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1" style="color: #667eea; font-weight: 700;">
                    <i class="fas fa-file-medical me-2"></i> Detail Konsultasi #{{ $konsultasi->id }}
                </h2>
                <p class="text-muted mb-0">Informasi lengkap konsultasi pasien</p>
            </div>

            <!-- Status Badge -->
            <span class="badge px-4 py-2" style="font-size: 1rem;
                @if($konsultasi->status == 'menunggu') background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
                @elseif($konsultasi->status == 'diproses') background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                @else background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                @endif">
                <i class="fas
                    @if($konsultasi->status == 'menunggu') fa-clock
                    @elseif($konsultasi->status == 'diproses') fa-user-md
                    @else fa-check-circle
                    @endif me-2"></i>
                {{ ucfirst($konsultasi->status) }}
            </span>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Informasi Pasien -->
            <div class="detail-card">
                <h5 class="fw-bold mb-4" style="color: #667eea;">
                    <i class="fas fa-user me-2"></i> Informasi Pasien
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="info-label">Nama Pasien</div>
                        <div class="info-value">{{ $konsultasi->user->name ?? 'Unknown' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $konsultasi->user->email ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Detail Konsultasi -->
            <div class="detail-card">
                <h5 class="fw-bold mb-4" style="color: #667eea;">
                    <i class="fas fa-stethoscope me-2"></i> Detail Konsultasi
                </h5>

                <div class="info-label">Topik</div>
                <div class="info-value fw-bold h5">{{ $konsultasi->topik ?? '-' }}</div>

                <div class="info-label">Kategori</div>
                <div class="mb-3">
                    <span class="badge bg-light text-primary">
                        <i class="fas fa-tag me-1"></i> {{ $konsultasi->kategori ?? 'Umum' }}
                    </span>
                    <span class="badge ms-2
                        @if($konsultasi->urgensi == 'tinggi') bg-danger
                        @elseif($konsultasi->urgensi == 'sedang') bg-warning text-dark
                        @else bg-success
                        @endif">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Urgensi: {{ ucfirst($konsultasi->urgensi ?? 'rendah') }}
                    </span>
                </div>

                <div class="info-label">Keluhan Utama</div>
                <div class="info-value bg-light p-3 rounded">{{ $konsultasi->keluhan }}</div>

                @if($konsultasi->gejala_tambahan)
                <div class="info-label">Gejala Tambahan</div>
                <div class="info-value bg-light p-3 rounded">{{ $konsultasi->gejala_tambahan }}</div>
                @endif

                @if($konsultasi->riwayat_alergi)
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-allergies me-2"></i>
                    <strong>Riwayat Alergi:</strong> {{ $konsultasi->riwayat_alergi }}
                </div>
                @endif

                <div class="info-label">Tanggal Konsultasi</div>
                <div class="info-value">
                    <i class="fas fa-calendar text-secondary me-2"></i>
                    {{ $konsultasi->created_at->format('d M Y, H:i') }}
                </div>
            </div>

            <!-- Jawaban Dokter -->
            @if($konsultasi->jawaban)
            <div class="detail-card" style="border-left: 4px solid #28a745;">
                <h5 class="fw-bold mb-3" style="color: #28a745;">
                    <i class="fas fa-user-md me-2"></i> Jawaban Tenaga Medis
                </h5>

                @if($konsultasi->dokter)
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width: 50px; height: 50px;">
                        <i class="fas fa-user-md text-success fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ $konsultasi->dokter }}</div>
                        <small class="text-muted">Tenaga Medis</small>
                    </div>
                </div>
                @endif

                <div class="bg-light p-3 rounded mb-3">
                    <div style="white-space: pre-line;">{{ $konsultasi->jawaban }}</div>
                </div>

                @if($konsultasi->rekomendasi_obat)
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-pills me-2"></i>
                    <strong>Rekomendasi Obat:</strong> {{ $konsultasi->rekomendasi_obat }}
                </div>
                @endif

                @if($konsultasi->dijawab_pada)
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Dijawab pada: {{ $konsultasi->dijawab_pada->format('d M Y, H:i') }}
                </small>
                @endif
            </div>
            @else
            <!-- Form Jawaban -->
            @if($konsultasi->status == 'diproses')
            <div class="detail-card" style="border: 2px dashed #667eea;">
                <h5 class="fw-bold mb-4" style="color: #667eea;">
                    <i class="fas fa-edit me-2"></i> Berikan Jawaban
                </h5>

                <form action="{{ route('mitra.konsultasi.jawab', $konsultasi->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Dokter/Apoteker</label>
                        <input type="text" class="form-control" name="dokter"
                               value="{{ old('dokter', Auth::user()->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jawaban Konsultasi <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="jawaban" rows="6" required
                                  placeholder="Berikan penjelasan detail, saran, dan rekomendasi untuk pasien...">{{ old('jawaban') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Rekomendasi Obat (Opsional)</label>
                        <input type="text" class="form-control" name="rekomendasi_obat"
                               value="{{ old('rekomendasi_obat') }}"
                               placeholder="Contoh: Paracetamol 500mg, OBH Combi">
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-gradient">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Jawaban
                        </button>
                    </div>
                </form>
            </div>
            @endif
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Timeline -->
            <div class="detail-card">
                <h5 class="fw-bold mb-4" style="color: #667eea;">
                    <i class="fas fa-history me-2"></i> Timeline
                </h5>

                <div class="timeline-item">
                    <div class="timeline-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Konsultasi Dibuat</div>
                        <small class="text-muted">{{ $konsultasi->created_at->format('d M Y, H:i') }}</small>
                    </div>
                </div>

                @if($konsultasi->status != 'menunggu')
                <div class="timeline-item">
                    <div class="timeline-icon" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Diklaim & Diproses</div>
                        <small class="text-muted">Sedang ditangani</small>
                    </div>
                </div>
                @endif

                @if($konsultasi->status == 'selesai')
                <div class="timeline-item">
                    <div class="timeline-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Konsultasi Selesai</div>
                        <small class="text-muted">{{ $konsultasi->updated_at->format('d M Y, H:i') }}</small>
                    </div>
                </div>
                @endif
            </div>

            <!-- Actions -->
            @if($konsultasi->status == 'diproses' && $konsultasi->jawaban)
            <div class="detail-card">
                <h5 class="fw-bold mb-3" style="color: #667eea;">Aksi</h5>
                <form action="{{ route('mitra.konsultasi.selesai', $konsultasi->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success w-100"
                            onclick="return confirm('Yakin ingin menyelesaikan konsultasi ini?')">
                        <i class="fas fa-check-circle me-2"></i> Tandai Selesai
                    </button>
                </form>
            </div>
            @endif

            <!-- Info -->
            <div class="detail-card bg-light">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-info-circle text-primary me-2"></i> Informasi
                </h6>
                <ul class="list-unstyled mb-0 small">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Jawaban harus profesional dan detail
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Berikan rekomendasi obat jika diperlukan
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Pastikan data pasien tetap rahasia
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
