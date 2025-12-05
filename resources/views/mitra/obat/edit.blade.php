@extends('mitra.layouts.app')

@section('title', 'Edit Obat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mitra.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mitra.obat.index') }}">Obat</a></li>
                    <li class="breadcrumb-item active">Edit Obat</li>
                </ol>
            </nav>
            <h2 class="fw-bold text-dark">Edit Obat</h2>
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

                    <form method="POST" action="{{ route('mitra.obat.update', $obat->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nama Obat <span class="text-danger">*</span></label>
                                <input type="text" name="nama_obat" class="form-control"
                                       value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Antibiotik" {{ old('kategori', $obat->kategori) == 'Antibiotik' ? 'selected' : '' }}>Antibiotik</option>
                                    <option value="Vitamin" {{ old('kategori', $obat->kategori) == 'Vitamin' ? 'selected' : '' }}>Vitamin</option>
                                    <option value="Analgesik" {{ old('kategori', $obat->kategori) == 'Analgesik' ? 'selected' : '' }}>Analgesik (Pereda Nyeri)</option>
                                    <option value="Antipiretik" {{ old('kategori', $obat->kategori) == 'Antipiretik' ? 'selected' : '' }}>Antipiretik (Penurun Panas)</option>
                                    <option value="Antasida" {{ old('kategori', $obat->kategori) == 'Antasida' ? 'selected' : '' }}>Antasida (Maag)</option>
                                    <option value="Suplemen" {{ old('kategori', $obat->kategori) == 'Suplemen' ? 'selected' : '' }}>Suplemen</option>
                                    <option value="Lainnya" {{ old('kategori', $obat->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga" class="form-control"
                                           value="{{ old('harga', $obat->harga) }}" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stok" class="form-control"
                                       value="{{ old('stok', $obat->stok) }}" min="0" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Efek Samping</label>
                                <textarea name="efek_samping" class="form-control" rows="3">{{ old('efek_samping', $obat->efek_samping) }}</textarea>
                                <small class="text-muted">Opsional: Sebutkan efek samping yang mungkin terjadi</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Cara Pakai</label>
                                <textarea name="cara_pakai" class="form-control" rows="3">{{ old('cara_pakai', $obat->cara_pakai) }}</textarea>
                                <small class="text-muted">Opsional: Petunjuk penggunaan obat</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Gambar Obat</label>

                                @if($obat->gambar)
                                <div class="mb-3">
                                    <p class="text-muted small">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $obat->gambar) }}"
                                         alt="{{ $obat->nama_obat }}"
                                         class="img-thumbnail"
                                         style="max-width: 200px;">
                                </div>
                                @endif

                                <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(event)">
                                <small class="text-muted">Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</small>

                                <div class="mt-3">
                                    <img id="imagePreview" src="" alt="Preview" style="max-width: 200px; display: none;" class="img-thumbnail">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Obat
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
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Info Update</h5>
                    <ul class="small">
                        <li class="mb-2">Perubahan akan langsung tersimpan setelah klik Update</li>
                        <li class="mb-2">Gambar lama akan diganti jika Anda upload gambar baru</li>
                        <li class="mb-2">Kosongkan field gambar jika tidak ingin mengubah</li>
                        <li class="mb-2">Pastikan informasi yang diubah sudah benar</li>
                        <li>Update stok secara berkala untuk akurasi data</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-history me-2 text-success"></i>Riwayat</h5>
                    <p class="small mb-2"><strong>Dibuat:</strong><br>{{ $obat->created_at->format('d M Y, H:i') }}</p>
                    <p class="small mb-0"><strong>Terakhir Diubah:</strong><br>{{ $obat->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    const preview = document.getElementById('imagePreview');

    reader.onload = function() {
        preview.src = reader.result;
        preview.style.display = 'block';
    }

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>
@endsection
