@extends('mitra.layouts.app')

@section('title', 'Jawab Konsultasi #' . $konsultasi->id)

@section('content')
<style>
    .message-box { background: #f8f9fa; border-radius: 10px; padding: 15px; margin: 15px 0; }
    .patient-info { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 10px; padding: 20px; }
    .char-counter { font-size: 0.85rem; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="text-center">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-reply text-primary"></i> Jawab Konsultasi
                </h2>
                <p class="text-muted">Berikan jawaban dan saran medis untuk pasien</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Patient Info -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="patient-info">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="fw-bold mb-2">Konsultasi #{{ $konsultasi->id }}</h4>
                                <p class="mb-1"><i class="fas fa-user"></i> {{ $konsultasi->user->name ?? 'Anonim' }}</p>
                                <p class="mb-0"><i class="fas fa-stethoscope"></i> {{ $konsultasi->kategori ?? 'Konsultasi Umum' }}</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <a href="{{ route('mitra.konsultasi.show', $konsultasi->id) }}" class="btn btn-light">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 mb-4 mb-md-0">
                    <!-- Complaint Summary -->
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-clipboard-list"></i> Ringkasan Keluhan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Keluhan Utama</label>
                                <div class="message-box">
                                    <p class="mb-0">{{ Str::limit($konsultasi->keluhan, 200) }}</p>
                                </div>
                            </div>

                            @if($konsultasi->gejala_tambahan)
                            <div class="mb-3">
                                <label class="form-label text-muted">Gejala Tambahan</label>
                                <div class="message-box">
                                    <p class="mb-0">{{ $konsultasi->gejala_tambahan }}</p>
                                </div>
                            </div>
                            @endif

                            @if($konsultasi->riwayat_alergi)
                            <div class="mb-3">
                                <label class="form-label text-muted"><i class="fas fa-exclamation-triangle text-warning"></i> Alergi</label>
                                <div class="alert alert-warning py-2">
                                    <p class="mb-0">{{ $konsultasi->riwayat_alergi }}</p>
                                </div>
                            </div>
                            @endif

                            <div class="mt-4">
                                <label class="form-label text-muted">Urgensi</label>
                                <p class="fw-bold">
                                    <span class="badge
                                        @if($konsultasi->urgensi == 'tinggi') bg-danger
                                        @elseif($konsultasi->urgensi == 'sedang') bg-warning
                                        @else bg-success @endif">
                                        {{ ucfirst($konsultasi->urgensi ?? 'rendah') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <!-- Answer Form -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-edit"></i> Form Jawaban</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('mitra.konsultasi.jawab', $konsultasi->id) }}" method="POST">
                                @csrf

                                <!-- Doctor's Name -->
                                <div class="mb-4">
                                    <label for="dokter" class="form-label fw-bold">
                                        <i class="fas fa-user-md"></i> Nama Dokter/Apoteker
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="dokter"
                                           name="dokter"
                                           value="{{ auth()->user()->mitra->nama_apotek }}"
                                           placeholder="Nama Anda">
                                    <div class="form-text">Akan ditampilkan sebagai penanggung jawab</div>
                                </div>

                                <!-- Answer -->
                                <div class="mb-4">
                                    <label for="jawaban" class="form-label fw-bold">
                                        <i class="fas fa-comment-medical"></i> Jawaban Medis
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control"
                                              id="jawaban"
                                              name="jawaban"
                                              rows="8"
                                              placeholder="Berikan jawaban yang jelas, informatif, dan membantu. Sertakan saran pengobatan jika diperlukan."
                                              required></textarea>
                                    <div class="d-flex justify-content-between mt-2">
                                        <div class="form-text">Minimal 100 karakter</div>
                                        <div class="char-counter text-muted" id="charCounter">0/1000</div>
                                    </div>
                                </div>

                                <!-- Medicine Recommendation -->
                                <div class="mb-4">
                                    <label for="rekomendasi_obat" class="form-label fw-bold">
                                        <i class="fas fa-pills"></i> Rekomendasi Obat (Opsional)
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="rekomendasi_obat"
                                           name="rekomendasi_obat"
                                           placeholder="Contoh: Paracetamol 500mg 3x sehari setelah makan">
                                    <div class="form-text">Pisahkan dengan koma jika lebih dari satu</div>
                                </div>

                                <!-- Tips Section -->
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-lightbulb"></i> Tips Menjawab Konsultasi:</h6>
                                    <ul class="mb-0 small">
                                        <li>Gunakan bahasa yang mudah dipahami</li>
                                        <li>Sertakan instruksi penggunaan obat yang jelas</li>
                                        <li>Berikan saran perawatan mandiri jika memungkinkan</li>
                                        <li>Ingatkan untuk segera ke dokter jika gejala memburuk</li>
                                    </ul>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                                    <a href="{{ route('mitra.konsultasi.show', $konsultasi->id) }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-paper-plane"></i> Kirim Jawaban
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Character counter
    const jawabanTextarea = document.getElementById('jawaban');
    const charCounter = document.getElementById('charCounter');
    const submitBtn = document.getElementById('submitBtn');

    jawabanTextarea.addEventListener('input', function() {
        const length = this.value.length;
        charCounter.textContent = `${length}/1000`;

        if (length < 100) {
            charCounter.classList.remove('text-success');
            charCounter.classList.add('text-danger');
            submitBtn.disabled = true;
        } else {
            charCounter.classList.remove('text-danger');
            charCounter.classList.add('text-success');
            submitBtn.disabled = false;
        }
    });

    // Auto-expand textarea
    jawabanTextarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            this.style.height = (this.scrollHeight) + 'px';
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const jawaban = jawabanTextarea.value.trim();

        if (jawaban.length < 100) {
            e.preventDefault();
            alert('Jawaban minimal 100 karakter. Mohon berikan jawaban yang lebih detail.');
            jawabanTextarea.focus();
            return false;
        }

        // Show loading
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        submitBtn.disabled = true;
    });

    // Template answers (quick buttons)
    const templates = {
        demam: "Untuk demam, saya sarankan:\n1. Istirahat yang cukup\n2. Perbanyak minum air putih\n3. Kompres dengan air hangat\n4. Gunakan Paracetamol 500mg setiap 4-6 jam jika demam tinggi\n\nJika demam tidak turun dalam 3 hari, segera periksa ke dokter.",
        batuk: "Untuk batuk, rekomendasi saya:\n1. Minum air hangat dengan madu dan lemon\n2. Hindari makanan/minuman dingin\n3. Gunakan masker jika keluar rumah\n4. Obat batuk seperti OBH atau Ambroxol sesuai petunjuk\n\nJika disertai sesak napas, segera ke dokter.",
        sakit_kepala: "Untuk sakit kepala:\n1. Istirahat di ruangan redup\n2. Kompres dahi dengan air dingin\n3. Minum Paracetamol 500mg jika sakit berlanjut\n4. Hindari stres dan kurang tidur\n\nJika sakit kepala sangat hebat atau disertai muntah, segera ke UGD."
    };

    // Auto-fill based on category
    const kategori = "{{ $konsultasi->kategori ?? '' }}".toLowerCase();
    if (kategori.includes('demam') && templates.demam) {
        jawabanTextarea.value = templates.demam;
        jawabanTextarea.dispatchEvent(new Event('input'));
    } else if (kategori.includes('batuk') && templates.batuk) {
        jawabanTextarea.value = templates.batuk;
        jawabanTextarea.dispatchEvent(new Event('input'));
    } else if ((kategori.includes('kepala') || kategori.includes('pusing')) && templates.sakit_kepala) {
        jawabanTextarea.value = templates.sakit_kepala;
        jawabanTextarea.dispatchEvent(new Event('input'));
    }
</script>
@endsection
