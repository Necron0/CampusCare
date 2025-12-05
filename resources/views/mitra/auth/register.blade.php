<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mitra - CampusCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 600px;
            margin: 0 auto;
        }
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .register-body {
            padding: 40px 30px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px;
            font-weight: 600;
        }
        .section-title {
            color: #667eea;
            font-weight: 600;
            margin-top: 20px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="register-header">
            <i class="fas fa-hospital-user fa-3x mb-3"></i>
            <h2 class="mb-0">Daftar Mitra Apotek</h2>
            <p class="mb-0 mt-2">Bergabung dengan CampusCare</p>
        </div>

        <div class="register-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi Kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('mitra.register.submit') }}">
                @csrf

                <h5 class="section-title">
                    <i class="fas fa-user me-2"></i>Informasi Akun
                </h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}" placeholder="John Doe" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" placeholder="email@apotek.com" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Min. 8 karakter" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Ulangi password" required>
                    </div>
                </div>

                <h5 class="section-title">
                    <i class="fas fa-store me-2"></i>Informasi Apotek
                </h5>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Apotek <span class="text-danger">*</span></label>
                    <input type="text" name="nama_apotek" class="form-control"
                           value="{{ old('nama_apotek') }}" placeholder="Apotek Sehat Sejahtera" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat Apotek <span class="text-danger">*</span></label>
                    <textarea name="alamat" class="form-control" rows="3"
                              placeholder="Jl. Kesehatan No. 123, Jakarta" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
                    <input type="tel" name="telepon" class="form-control"
                           value="{{ old('telepon') }}" placeholder="081234567890" required>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>
                        Akun Anda akan diverifikasi oleh admin sebelum dapat digunakan.
                        Proses verifikasi biasanya memakan waktu 1-2 hari kerja.
                    </small>
                </div>

                <button type="submit" class="btn btn-register w-100 mb-3">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sebagai Mitra
                </button>

                <div class="text-center">
                    <p class="mb-0">Sudah punya akun?
                        <a href="{{ route('mitra.login') }}" class="text-decoration-none fw-bold">
                            Login di sini
                        </a>
                    </p>
                    <hr class="my-3">
                    <a href="{{ route('login') }}" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Login Utama
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
