@extends('mitra.layouts.app')

@section('title', 'Manajemen Obat')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold text-dark">Manajemen Obat</h2>
            <p class="text-muted">Kelola daftar obat yang tersedia di apotek Anda</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('mitra.obat.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Obat
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Obat Cards -->
    <div class="row g-3">
        @forelse($obats as $obat)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm hover-card">
                @if($obat->gambar)
                <img src="{{ asset('storage/' . $obat->gambar) }}" class="card-img-top" alt="{{ $obat->nama_obat }}" style="height: 200px; object-fit: cover;">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-pills fa-4x text-muted"></i>
                </div>
                @endif

                <div class="card-body">
                    <h5 class="card-title mb-2">{{ $obat->nama_obat }}</h5>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-tag me-1"></i>{{ $obat->kategori }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="text-primary mb-0">Rp {{ number_format($obat->harga, 0, ',', '.') }}</h5>
                        </div>
                        <div>
                            @if($obat->stok > 10)
                            <span class="badge bg-success">Stok: {{ $obat->stok }}</span>
                            @elseif($obat->stok > 0)
                            <span class="badge bg-warning">Stok: {{ $obat->stok }}</span>
                            @else
                            <span class="badge bg-danger">Habis</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('mitra.obat.show', $obat->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>Detail
                        </a>
                        <div class="btn-group">
                            <a href="{{ route('mitra.obat.edit', $obat->id) }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteObat({{ $obat->id }})">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-pills fa-4x text-muted mb-3"></i>
                    <h5>Belum Ada Obat</h5>
                    <p class="text-muted">Mulai tambahkan obat ke daftar Anda</p>
                    <a href="{{ route('mitra.obat.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Obat Pertama
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($obats->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            {{ $obats->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Delete Form (hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
.hover-card {
    transition: transform 0.2s;
}
.hover-card:hover {
    transform: translateY(-5px);
}
</style>

<script>
function deleteObat(id) {
    if (confirm('Apakah Anda yakin ingin menghapus obat ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/mitra/obat/${id}`;
        form.submit();
    }
}
</script>
@endsection
