@extends('mitra.layouts.app')

@section('title', 'Tambah Promosi')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mitra.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mitra.promosi.index') }}">Promosi</a></li>
                    <li class="breadcrumb-item active">Tambah Promosi</li>
                </ol>
            </nav>
            <h2 class="fw-bold text-dark">Tambah Promosi Baru</h2>
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

                    <form method="POST" action="{{ route('mitra.promosi.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nama Promosi</label>
                                <input type="text" name="nama_promosi" class="form-control"
                                       value="{{ old('nama_promosi') }}"
                                       placeholder="Contoh: Promo Lebaran 2025">
                                <small class="text-muted">Opsional: Beri nama untuk promosi ini</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Pilih Obat <span class="text-danger">*</span></label>
                                <select name="obat_id" id="obatSelect" class="form-select" required onchange="updateHargaObat()">
                                    <option value="">Pilih Obat</option>
                                    @foreach($obats as $obat)
                                    <option value="{{ $obat->id }}"
                                            data-harga="{{ $obat->harga }}"
                                            {{ old('obat_id') == $obat->id ? 'selected' : '' }}>
                                        {{ $obat->nama_obat }} - Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Deskripsi Promosi</label>
                                <textarea name="deskripsi" class="form-control" rows="3"
                                          placeholder="Contoh: Diskon spesial untuk Anda!">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Diskon (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="diskon" id="nilaiDiskon" class="form-control"
                                           value="{{ old('diskon') }}"
                                           min="1" max="100" required
                                           onkeyup="hitungHargaDiskon()"
                                           placeholder="Contoh: 25">
                                    <span class="input-group-text">%</span>
                                </div>
                                <small class="text-muted">Masukkan nilai diskon 1-100%</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="mulai" class="form-control"
                                       value="{{ old('mulai', date('Y-m-d')) }}"
                                       min="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Berakhir <span class="text-danger">*</span></label>
                                <input type="date" name="berakhir" class="form-control"
                                       value="{{ old('berakhir') }}"
                                       min="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="aktif" id="aktif"
                                           value="1" {{ old('aktif', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="aktif">
                                        Aktifkan Promosi
                                    </label>
                                    <small class="d-block text-muted">Promosi yang aktif akan langsung tampil untuk pelanggan</small>
                                </div>
                            </div>

                            <!-- Preview Harga -->
                            <div class="col-md-12 mb-3" id="previewHarga" style="display: none;">
                                <div class="alert alert-warning">
                                    <h6 class="fw-bold"><i class="fas fa-calculator me-2"></i>Preview Harga:</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <strong>Harga Normal:</strong><br>
                                            <span id="hargaNormal">Rp 0</span>
                                        </div>
                                        <div class="col-6">
                                            <strong>Harga Setelah Diskon:</strong><br>
                                            <span id="hargaDiskon" class="text-success fw-bold">Rp 0</span>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Hemat:</strong>
                                        <span id="hemat" class="text-danger fw-bold">Rp 0</span>
                                        (<span id="persenDiskon"></span>%)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Promosi
                            </button>
                            <a href="{{ route('mitra.promosi.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Tips Promosi</h5>
                    <ul class="small">
                        <li class="mb-2">Buat nama promosi yang menarik dan mudah diingat</li>
                        <li class="mb-2">Pilih obat yang paling banyak dicari untuk promo</li>
                        <li class="mb-2">Diskon 10-30% biasanya paling efektif</li>
                        <li class="mb-2">Atur periode promosi sesuai event (Lebaran, Natal, dll)</li>
                        <li class="mb-2">Aktifkan promosi saat sudah siap dipublikasikan</li>
                        <li>Monitor performa promosi secara berkala</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-2"><i class="fas fa-lightbulb me-2 text-warning"></i>Contoh Promosi</h6>
                    <div class="small">
                        <strong>✅ Promo Lebaran:</strong><br>
                        Diskon 25% untuk obat maag<br>
                        Periode: 1-10 Ramadhan
                        <hr>
                        <strong>✅ Flash Sale:</strong><br>
                        Potongan 50% hanya weekend<br>
                        Periode: Sabtu-Minggu
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateHargaObat() {
    hitungHargaDiskon();
}

function hitungHargaDiskon() {
    const obatSelect = document.getElementById('obatSelect');
    const nilaiDiskon = parseFloat(document.getElementById('nilaiDiskon').value) || 0;

    if (!obatSelect.value || nilaiDiskon <= 0) {
        document.getElementById('previewHarga').style.display = 'none';
        return;
    }

    // Validasi diskon 1-100
    if (nilaiDiskon > 100) {
        alert('Diskon tidak boleh lebih dari 100%');
        document.getElementById('nilaiDiskon').value = 100;
        return;
    }

    const hargaAsli = parseFloat(obatSelect.options[obatSelect.selectedIndex].dataset.harga);
    const hargaSetelahDiskon = hargaAsli - (hargaAsli * nilaiDiskon / 100);
    const hemat = hargaAsli - hargaSetelahDiskon;

    // Update display
    document.getElementById('hargaNormal').textContent = formatRupiah(hargaAsli);
    document.getElementById('hargaDiskon').textContent = formatRupiah(hargaSetelahDiskon);
    document.getElementById('hemat').textContent = formatRupiah(hemat);
    document.getElementById('persenDiskon').textContent = nilaiDiskon;
    document.getElementById('previewHarga').style.display = 'block';
}

function formatRupiah(angka) {
    return 'Rp ' + Math.round(angka).toLocaleString('id-ID');
}
</script>
@endsection
