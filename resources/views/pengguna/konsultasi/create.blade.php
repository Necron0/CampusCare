<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Konsultasi Baru - CampusCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .card-header {
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }
        .btn-primary {
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
            border: none;
            padding: 10px 30px;
            border-radius: 30px;
            font-weight: 600;
        }
        .btn-outline-secondary {
            border-radius: 30px;
            padding: 10px 30px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4facfe;
            box-shadow: 0 0 0 0.25rem rgba(79, 172, 254, 0.25);
        }
        .info-box {
            background: rgba(23, 162, 184, 0.1);
            border-left: 4px solid #17a2b8;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="text-white display-4 fw-bold mb-3">
                        <i class="fas fa-comment-medical"></i> Konsultasi Kesehatan
                    </h1>
                    <p class="text-white-50 lead">Konsultasikan keluhan kesehatan Anda dengan tenaga medis profesional</p>
                </div>

                <!-- Main Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-file-medical"></i> Form Konsultasi Baru
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('pengguna.konsultasi.store') }}" method="POST">
                            @csrf

                            <!-- Alert jika ada error -->
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><i class="fas fa-exclamation-triangle"></i> Perhatikan!</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="row">
                                <!-- Kategori Keluhan -->
                                <div class="col-md-6 mb-3">
                                    <label for="kategori" class="form-label fw-bold">
                                        <i class="fas fa-tags text-primary"></i> Kategori Keluhan (Opsional)
                                    </label>
                                    <select class="form-select @error('kategori') is-invalid @enderror"
                                            id="kategori" name="kategori">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Demam" {{ old('kategori') == 'Demam' ? 'selected' : '' }}>Demam</option>
                                        <option value="Batuk" {{ old('kategori') == 'Batuk' ? 'selected' : '' }}>Batuk & Flu</option>
                                        <option value="Pencernaan" {{ old('kategori') == 'Pencernaan' ? 'selected' : '' }}>Pencernaan</option>
                                        <option value="Kulit" {{ old('kategori') == 'Kulit' ? 'selected' : '' }}>Kulit & Alergi</option>
                                        <option value="Kepala" {{ old('kategori') == 'Kepala' ? 'selected' : '' }}>Sakit Kepala</option>
                                        <option value="Tenggorokan" {{ old('kategori') == 'Tenggorokan' ? 'selected' : '' }}>Tenggorokan</option>
                                        <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Topik Konsultasi -->
                                <div class="col-md-6 mb-3">
                                    <label for="topik" class="form-label fw-bold">
                                        <i class="fas fa-heading text-primary"></i> Topik Konsultasi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('topik') is-invalid @enderror"
                                           id="topik"
                                           name="topik"
                                           value="{{ old('topik') }}"
                                           placeholder="Contoh: Batuk Berdahak 3 Hari"
                                           required>
                                    @error('topik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Keluhan Utama -->
                            <div class="mb-3">
                                <label for="keluhan" class="form-label fw-bold">
                                    <i class="fas fa-stethoscope text-primary"></i> Keluhan Utama <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('keluhan') is-invalid @enderror"
                                          id="keluhan"
                                          name="keluhan"
                                          rows="4"
                                          placeholder="Ceritakan keluhan kesehatan Anda secara detail. Contoh: Sudah berapa hari? Gejala apa saja yang dirasakan?"
                                          required>{{ old('keluhan') }}</textarea>
                                <div class="form-text">Jelaskan gejala, sudah berapa lama, dan seberapa parah.</div>
                                @error('keluhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gejala Tambahan -->
                            <div class="mb-3">
                                <label for="gejala_tambahan" class="form-label fw-bold">
                                    <i class="fas fa-plus-circle text-primary"></i> Gejala Tambahan (Opsional)
                                </label>
                                <textarea class="form-control @error('gejala_tambahan') is-invalid @enderror"
                                          id="gejala_tambahan"
                                          name="gejala_tambahan"
                                          rows="3"
                                          placeholder="Gejala lain yang menyertai seperti mual, pusing, atau lemas...">{{ old('gejala_tambahan') }}</textarea>
                                @error('gejala_tambahan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Riwayat Alergi -->
                                <div class="col-md-6 mb-3">
                                    <label for="riwayat_alergi" class="form-label fw-bold">
                                        <i class="fas fa-allergies text-warning"></i> Riwayat Alergi (Opsional)
                                    </label>
                                    <input type="text"
                                           class="form-control @error('riwayat_alergi') is-invalid @enderror"
                                           id="riwayat_alergi"
                                           name="riwayat_alergi"
                                           value="{{ old('riwayat_alergi') }}"
                                           placeholder="Contoh: Paracetamol, Debu, Udara Dingin">
                                    <div class="form-text">Kosongkan jika tidak ada alergi</div>
                                    @error('riwayat_alergi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tingkat Urgensi -->
                                <div class="col-md-6 mb-3">
                                    <label for="urgensi" class="form-label fw-bold">
                                        <i class="fas fa-exclamation-triangle text-danger"></i> Tingkat Urgensi (Opsional)
                                    </label>
                                    <select class="form-select @error('urgensi') is-invalid @enderror"
                                            id="urgensi"
                                            name="urgensi">
                                        <option value="rendah" {{ old('urgensi', 'rendah') == 'rendah' ? 'selected' : '' }}>Rendah (Bisa ditangani nanti)</option>
                                        <option value="sedang" {{ old('urgensi') == 'sedang' ? 'selected' : '' }}>Sedang (Butuh perhatian segera)</option>
                                        <option value="tinggi" {{ old('urgensi') == 'tinggi' ? 'selected' : '' }}>Tinggi (Segera ke UGD)</option>
                                    </select>
                                    @error('urgensi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                                <a href="{{ route('pengguna.konsultasi.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Kirim Konsultasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="card info-box">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle text-info"></i> Informasi Penting:
                        </h5>
                        <ul class="mb-0">
                            <li>Konsultasi akan dijawab oleh tenaga medis/apoteker dalam waktu 1x24 jam</li>
                            <li>Untuk keadaan darurat (urgensi tinggi), segera hubungi UGD terdekat atau <strong>119</strong></li>
                            <li>Jangan menyertakan informasi yang tidak relevan dengan keluhan kesehatan</li>
                            <li>Hasil konsultasi <strong>bukan pengganti diagnosis dokter</strong> secara langsung</li>
                            <li>Gunakan bahasa yang jelas dan deskriptif untuk membantu diagnosis</li>
                        </ul>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4 text-white-50">
                    <p class="mb-0">
                        <i class="fas fa-heartbeat"></i> CampusCare - Sistem Konsultasi Kesehatan Kampus
                        <br>
                        <small>© 2024 Hak Cipta Dilindungi</small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-fill topik berdasarkan kategori
        document.getElementById('kategori').addEventListener('change', function() {
            const topikInput = document.getElementById('topik');
            const kategori = this.value;

            if (kategori && !topikInput.value) {
                const topikMap = {
                    'Demam': 'Demam dan Suhu Tinggi',
                    'Batuk': 'Batuk dan Flu Berkepanjangan',
                    'Pencernaan': 'Masalah Pencernaan dan Perut',
                    'Kulit': 'Masalah Kulit dan Alergi',
                    'Kepala': 'Sakit Kepala Berkelanjutan',
                    'Tenggorokan': 'Sakit Tenggorokan dan Kesulitan Menelan',
                    'Lainnya': 'Konsultasi Kesehatan Umum'
                };

                if (topikMap[kategori]) {
                    topikInput.value = topikMap[kategori];
                }
            }
        });

        // Warning untuk urgensi tinggi
        document.getElementById('urgensi').addEventListener('change', function() {
            if (this.value === 'tinggi') {
                const confirmMessage = '⚠️ PERINGATAN: Anda memilih urgensi TINGGI.\n\n' +
                    'Jika ini keadaan darurat (sesak napas, nyeri dada hebat, pendarahan berat, atau kehilangan kesadaran):\n' +
                    '1. Segera hubungi UGD atau nomor darurat 119\n' +
                    '2. Jangan menunggu konsultasi online\n\n' +
                    'Apakah Anda yakin ingin melanjutkan dengan konsultasi online?';

                if (!confirm(confirmMessage)) {
                    this.value = 'rendah';
                }
            }
        });

        // Form validation on submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const keluhan = document.getElementById('keluhan').value.trim();
            if (keluhan.length < 10) {
                e.preventDefault();
                alert('Mohon isi keluhan utama dengan lebih detail (minimal 10 karakter)');
                document.getElementById('keluhan').focus();
                return false;
            }

            // Cek urgensi tinggi - warning lagi
            const urgensi = document.getElementById('urgensi').value;
            if (urgensi === 'tinggi') {
                const finalWarning = '⚠️ PERINGATAN AKHIR:\n' +
                    'Anda telah memilih urgensi TINGGI.\n' +
                    'Pastikan ini bukan keadaan darurat yang memerlukan penanganan langsung.\n\n' +
                    'Klik OK untuk mengirim konsultasi, atau Cancel untuk kembali ke form.';

                if (!confirm(finalWarning)) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    </script>
</body>
</html>
