@extends('mitra.layouts.app')

@section('title', 'Tambah Obat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mitra.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mitra.obat.index') }}">Obat</a></li>
                    <li class="breadcrumb-item active">Tambah Obat</li>
                </ol>
            </nav>
            <h2 class="fw-bold text-dark">Tambah Obat Baru</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('mitra.obat.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nama Obat <span class="text-danger">*</span></label>
                                <input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Antibiotik">Antibiotik</option>
                                    <option value="Vitamin">Vitamin</option>
                                    <option value="Analgesik">Analgesik (Pereda Nyeri)</option>
                                    <option value="Antipiretik">Antipiretik (Penurun Panas)</option>
                                    <option value="Antasida">Antasida (Maag)</option>
                                    <option value="Suplemen">Suplemen</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stok" class="form-control" value="{{ old('stok') }}" min="0" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Gejala</label>
                                <textarea name="gejala" class="form-control" rows="3" placeholder="Contoh: Demam, Batuk, Pilek">{{ old('gejala') }}</textarea>
                                <small class="text-muted">Opsional: Gejala yang bisa diatasi obat ini</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Lokasi Apotek</label>
                                <input type="text" name="lokasi_apotek" class="form-control" placeholder="Contoh: Rak A, Lantai 2">
                                <small class="text-muted">Opsional: Lokasi obat di apotek Anda</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                                    <label class="form-check-label fw-bold" for="is_active">Aktifkan Obat</label>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Gambar Obat</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(event)">
                                <small class="text-muted">Format: JPG, PNG. Maksimal 2MB. Opsional.</small>
                                <div class="mt-3" id="previewContainer" style="display: none;">
                                    <p class="text-muted small mb-2">Preview Gambar:</p>
                                    <img id="imagePreview" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Obat
                            </button>
                            <a href="{{ route('mitra.obat.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Petunjuk</h5>
                    <ul class="small">
                        <li class="mb-2">Pastikan nama obat ditulis dengan benar dan lengkap</li>
                        <li class="mb-2">Pilih kategori yang sesuai untuk memudahkan pencarian</li>
                        <li class="mb-2">Harga dalam Rupiah tanpa tanda titik atau koma</li>
                        <li class="mb-2">Update stok secara berkala</li>
                        <li class="mb-2">Gambar yang jelas akan meningkatkan kepercayaan pembeli</li>
                        <li>Lengkapi informasi efek samping dan cara pakai untuk keamanan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    const preview = document.getElementById('imagePreview');
    const container = document.getElementById('previewContainer');

    reader.onload = function() {
        preview.src = reader.result;
        container.style.display = 'block';
    }

    if (event.target.files[0]) {
        // Validasi ukuran file (2MB)
        if (event.target.files[0].size > 2048000) {
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            event.target.value = '';
            container.style.display = 'none';
            return;
        }
        reader.readAsDataURL(event.target.files[0]);
    } else {
        container.style.display = 'none';
    }
}
</script>
@endsection
