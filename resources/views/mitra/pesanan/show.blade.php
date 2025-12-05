@extends('mitra.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mitra.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mitra.pesanan.index') }}">Pesanan</a></li>
                    <li class="breadcrumb-item active">Detail #{{ $pesanan->id }}</li>
                </ol>
            </nav>
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

    <div class="row">
        <!-- Info Pesanan & Items -->
        <div class="col-lg-8">
            <!-- Header Pesanan -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="fw-bold mb-2">Pesanan #{{ $pesanan->id }}</h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-calendar me-2"></i>{{ $pesanan->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            @php
                                $statusConfig = [
                                    'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Pesanan Baru'],
                                    'diproses' => ['class' => 'info', 'icon' => 'spinner', 'text' => 'Diproses'],
                                    'dikirim' => ['class' => 'primary', 'icon' => 'truck', 'text' => 'Dikirim'],
                                    'selesai' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Selesai'],
                                    'dibatalkan' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'Dibatalkan']
                                ];
                                $config = $statusConfig[$pesanan->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => ucfirst($pesanan->status)];
                            @endphp
                            <span class="badge bg-{{ $config['class'] }} px-3 py-2" style="font-size: 14px;">
                                <i class="fas fa-{{ $config['icon'] }} me-1"></i>{{ $config['text'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Info Pelanggan -->
                    <div class="border-top pt-3">
                        <h6 class="fw-bold mb-3"><i class="fas fa-user me-2 text-primary"></i>Informasi Pelanggan</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Nama:</strong> {{ $pesanan->nama_penerima ?? $pesanan->user->name }}</p>
                                <p class="mb-2"><strong>Email:</strong> {{ $pesanan->user->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>No. HP:</strong> {{ $pesanan->no_hp ?? '-' }}</p>
                                <p class="mb-2"><strong>Opsi Pengiriman:</strong> {{ ucfirst($pesanan->opsi_pengiriman ?? 'pickup') }}</p>
                            </div>
                        </div>
                        <p class="mb-0 mt-2">
                            <strong>Alamat Pengiriman:</strong><br>
                            {{ $pesanan->alamat_pengiriman ?? 'Ambil di apotek' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Items Pesanan -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-pills me-2 text-primary"></i>Items Pesanan</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Obat</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pesanan->orderItems as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->obat->nama_obat }}</strong><br>
                                        <small class="text-muted">{{ $item->obat->kategori }}</small>
                                    </td>
                                    <td class="text-center">{{ $item->jumlah }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                @if(isset($pesanan->ongkir) && $pesanan->ongkir > 0)
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Ongkos Kirim:</strong></td>
                                    <td class="text-end">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td class="text-end">
                                        <h5 class="mb-0 text-primary">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            @if($pesanan->catatan)
            <div class="alert alert-info mt-3">
                <strong><i class="fas fa-sticky-note me-2"></i>Catatan:</strong><br>
                {{ $pesanan->catatan }}
            </div>
            @endif
        </div>

        <!-- Aksi & Timeline -->
        <div class="col-lg-4">
            <!-- Aksi Cepat -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    @if($pesanan->status == 'pending')
                        <form method="POST" action="{{ route('mitra.pesanan.update-status', $pesanan->id) }}" class="d-grid gap-2 mb-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="diproses">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-spinner me-2"></i>Proses Pesanan
                            </button>
                        </form>
                        <button class="btn btn-danger w-100" onclick="showBatalkanModal()">
                            <i class="fas fa-times me-2"></i>Batalkan Pesanan
                        </button>
                    @elseif($pesanan->status == 'diproses')
                        <form method="POST" action="{{ route('mitra.pesanan.update-status', $pesanan->id) }}" class="d-grid gap-2 mb-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="dikirim">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-truck me-2"></i>Kirim Pesanan
                            </button>
                        </form>
                        <button class="btn btn-danger w-100" onclick="showBatalkanModal()">
                            <i class="fas fa-times me-2"></i>Batalkan Pesanan
                        </button>
                    @elseif($pesanan->status == 'dikirim')
                        <form method="POST" action="{{ route('mitra.pesanan.konfirmasi-diterima', $pesanan->id) }}" class="d-grid">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-2"></i>Konfirmasi Diterima
                            </button>
                        </form>
                    @elseif($pesanan->status == 'selesai')
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-check-circle me-2"></i>Pesanan telah selesai
                        </div>
                    @elseif($pesanan->status == 'dibatalkan')
                        <div class="alert alert-danger mb-0">
                            <i class="fas fa-times-circle me-2"></i>Pesanan dibatalkan
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline Status -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Timeline Status</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item {{ $pesanan->status == 'pending' ? 'active' : 'completed' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Pesanan Dibuat</h6>
                                <small class="text-muted">{{ $pesanan->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>

                        <div class="timeline-item {{ in_array($pesanan->status, ['diproses', 'dikirim', 'selesai']) ? 'completed' : ($pesanan->status == 'diproses' ? 'active' : '') }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Diproses</h6>
                                <small class="text-muted">{{ in_array($pesanan->status, ['diproses', 'dikirim', 'selesai']) ? 'Sedang diproses' : 'Menunggu' }}</small>
                            </div>
                        </div>

                        <div class="timeline-item {{ in_array($pesanan->status, ['dikirim', 'selesai']) ? 'completed' : ($pesanan->status == 'dikirim' ? 'active' : '') }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Dikirim</h6>
                                <small class="text-muted">{{ in_array($pesanan->status, ['dikirim', 'selesai']) ? 'Dalam pengiriman' : 'Menunggu' }}</small>
                            </div>
                        </div>

                        <div class="timeline-item {{ $pesanan->status == 'selesai' ? 'completed' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Selesai</h6>
                                <small class="text-muted">{{ $pesanan->status == 'selesai' ? 'Pesanan selesai' : 'Menunggu' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <a href="{{ route('mitra.pesanan.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>
</div>

<!-- Modal Batalkan -->
<div class="modal fade" id="batalkanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Batalkan Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('mitra.pesanan.batalkan', $pesanan->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Stok obat akan dikembalikan setelah pembatalan.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alasan Pembatalan</label>
                        <textarea name="alasan" class="form-control" rows="3" required placeholder="Contoh: Stok obat habis"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Batalkan Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 30px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -20px;
    top: 20px;
    bottom: -10px;
    width: 2px;
    background: #e9ecef;
}

.timeline-item:last-child::before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    top: 0;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #e9ecef;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-item.active .timeline-marker {
    background: #ffc107;
    box-shadow: 0 0 0 2px #ffc107;
}

.timeline-item.completed .timeline-marker {
    background: #28a745;
    box-shadow: 0 0 0 2px #28a745;
}

.timeline-item.completed::before {
    background: #28a745;
}
</style>

<script>
function showBatalkanModal() {
    const modal = new bootstrap.Modal(document.getElementById('batalkanModal'));
    modal.show();
}
</script>
@endsection
