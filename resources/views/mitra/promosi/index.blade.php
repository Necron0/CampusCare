@extends('mitra.layouts.app')

@section('title', 'Manajemen Promosi')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold text-dark">Manajemen Promosi</h2>
            <p class="text-muted">Kelola promo dan diskon untuk obat Anda</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('mitra.promosi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Promosi
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        @foreach($errors->all() as $error)
            <i class="fas fa-exclamation-circle me-2"></i>{{ $error }}<br>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-tag"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Promosi</h6>
                            <h3 class="mb-0 fw-bold">{{ $totalPromosi }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Promo Aktif</h6>
                            <h3 class="mb-0 fw-bold">{{ $promosiAktif }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Expired</h6>
                            <h3 class="mb-0 fw-bold">{{ $promosiExpired }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('mitra.promosi.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Filter Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Jenis Diskon</label>
                    <select name="jenis" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Jenis</option>
                        <option value="persen" {{ request('jenis') == 'persen' ? 'selected' : '' }}>Diskon Persen (%)</option>
                        <option value="nominal" {{ request('jenis') == 'nominal' ? 'selected' : '' }}>Diskon Nominal (Rp)</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <a href="{{ route('mitra.promosi.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Promosi -->
    <div class="row g-3">
        @forelse($promosis as $promosi)
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-2">{{ $promosi->nama_promosi }}</h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-pills me-2"></i>{{ $promosi->obat->nama_obat }}
                            </p>
                        </div>
                        <div>
                            @if($promosi->aktif && \Carbon\Carbon::parse($promosi->berakhir)->isFuture())
                                <span class="badge bg-success px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                </span>
                            @elseif(\Carbon\Carbon::parse($promosi->berakhir)->isPast())
                                <span class="badge bg-danger px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>Expired
                                </span>
                            @else
                                <span class="badge bg-secondary px-3 py-2">
                                    <i class="fas fa-pause me-1"></i>Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($promosi->deskripsi)
                    <p class="text-muted small mb-3">{{ $promosi->deskripsi }}</p>
                    @endif

                    <!-- Diskon Info -->
                    <div class="alert alert-warning mb-3">
                        <div class="row">
                            <div class="col-6">
                                <strong>Diskon:</strong><br>
                                <span class="badge bg-warning text-dark fs-6">{{ $promosi->diskon }}% OFF</span>
                            </div>
                            <div class="col-6">
                                <strong>Harga:</strong><br>
                                <del class="text-muted">Rp {{ number_format($promosi->obat->harga, 0, ',', '.') }}</del><br>
                                @php
                                    $hargaDiskon = $promosi->obat->harga - ($promosi->obat->harga * $promosi->diskon / 100);
                                @endphp
                                <span class="text-success fw-bold">Rp {{ number_format($hargaDiskon, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Periode -->
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-2"></i>
                            {{ \Carbon\Carbon::parse($promosi->mulai)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($promosi->berakhir)->format('d M Y') }}
                        </small>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('mitra.promosi.edit', $promosi->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        @if(!\Carbon\Carbon::parse($promosi->berakhir)->isPast())
                        <form method="POST" action="{{ route('mitra.promosi.toggle-status', $promosi->id) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-outline-{{ $promosi->aktif ? 'secondary' : 'success' }}">
                                <i class="fas fa-{{ $promosi->aktif ? 'pause' : 'play' }}"></i>
                                {{ $promosi->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        @endif

                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletePromosi({{ $promosi->id }})">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                    <h5>Belum Ada Promosi</h5>
                    <p class="text-muted">Mulai buat promosi untuk menarik lebih banyak pembeli</p>
                    <a href="{{ route('mitra.promosi.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Promosi Pertama
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($promosis->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            {{ $promosis->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Delete Form (hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deletePromosi(id) {
    if (confirm('Apakah Anda yakin ingin menghapus promosi ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/mitra/promosi/${id}`;
        form.submit();
    }
}
</script>
@endsection
