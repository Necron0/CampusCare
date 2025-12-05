@extends('mitra.layouts.app')

@section('title', 'Detail Obat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mitra.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mitra.obat.index') }}">Obat</a></li>
                    <li class="breadcrumb-item active">{{ $obat->nama_obat }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Image & Main Info -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-0">
                    @if($obat->gambar)
                    <img src="{{ asset('storage/' . $obat->gambar) }}"
                         alt="{{ $obat->nama_obat }}"
                         class="w-100"
                         style="max-height: 400px; object-fit: cover;">
                    @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <div class="text-center">
                            <i class="fas fa-pills fa-5x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada gambar</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-grid gap-2">
                <a href="{{ route('mitra.obat.edit', $obat->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit Obat
                </a>
                <button type="button" class="btn btn-danger" onclick="deleteObat()">
                    <i class="fas fa-trash me-2"></i>Hapus Obat
                </button>
                <a href="{{ route('mitra.obat.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Details -->
        <div class="col-lg-7">
            <!-- Header Info -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="fw-bold mb-2">{{ $obat->nama_obat }}</h2>
                            <span class="badge bg-primary px-3 py-2">
                                <i class="fas fa-tag me-1"></i>{{ $obat->kategori }}
                            </span>
                        </div>
                        <div class="text-end">
                            <h3 class="text-primary mb-0">Rp {{ number_format($obat->harga, 0, ',', '.') }}</h3>
                            <small class="text-muted">per unit</small>
                        </div>
                    </div>

                    <!-- Stok -->
                    <div class="alert alert-{{ $obat->stok > 10 ? 'success' : ($obat->stok > 0 ? 'warning' : 'danger') }} mb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-boxes me-2"></i>
                                <strong>Stok Tersedia:</strong> {{ $obat->stok }} unit
                            </div>
                            <button class="btn btn-sm btn-outline-dark" onclick="showStokModal()">
                                <i class="fas fa-edit"></i> Update Stok
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-align-left me-2 text-primary"></i>Deskripsi Obat
                    </h5>
                    <p class="text-muted" style="white-space: pre-line;">{{ $obat->deskripsi }}</p>
                </div>
            </div>

            <!-- Efek Samping -->
            @if($obat->efek_samping)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-exclamation-triangle me-2 text-warning"></i>Efek Samping
                    </h5>
                    <p class="text-muted" style="white-space: pre-line;">{{ $obat->efek_samping }}</p>
                </div>
            </div>
            @endif

            <!-- Cara Pakai -->
            @if($obat->cara_pakai)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-prescription me-2 text-success"></i>Cara Pakai
                    </h5>
                    <p class="text-muted" style="white-space: pre-line;">{{ $obat->cara_pakai }}</p>
                </div>
            </div>
            @endif

            <!-- Info Tambahan -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-info-circle me-2 text-info"></i>Informasi Tambahan
                    </h5>
                    <div class="row g-3">
                        <div class="col-6">
                            <small class="text-muted d-block">ID Obat</small>
                            <strong>#{{ $obat->id }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Kategori</small>
                            <strong>{{ $obat->kategori }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Tanggal Ditambahkan</small>
                            <strong>{{ $obat->created_at->format('d M Y') }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Terakhir Diubah</small>
                            <strong>{{ $obat->updated_at->format('d M Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Stok -->
<div class="modal fade" id="stokModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-boxes me-2"></i>Update Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Stok Saat Ini</label>
                    <input type="text" class="form-control" value="{{ $obat->stok }} unit" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Stok Baru</label>
                    <input type="number" id="newStok" class="form-control" value="{{ $obat->stok }}" min="0" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateStok()">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form (hidden) -->
<form id="deleteForm" method="POST" action="{{ route('mitra.obat.destroy', $obat->id) }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function showStokModal() {
    const modal = new bootstrap.Modal(document.getElementById('stokModal'));
    modal.show();
}

function updateStok() {
    const newStok = document.getElementById('newStok').value;

    if (newStok < 0) {
        alert('Stok tidak boleh kurang dari 0');
        return;
    }

    fetch(`/mitra/obat/{{ $obat->id }}/update-stok`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ stok: newStok })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Stok berhasil diperbarui!');
            location.reload();
        } else {
            alert('Gagal memperbarui stok');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function deleteObat() {
    if (confirm('Apakah Anda yakin ingin menghapus obat "{{ $obat->nama_obat }}"?\n\nData yang sudah dihapus tidak dapat dikembalikan!')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>

@endsection
