@extends('mitra.layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold text-dark">Manajemen Pesanan</h2>
            <p class="text-muted">Kelola pesanan yang masuk dari pelanggan</p>
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
        <i class="fas fa-exclamation-circle me-2"></i>
        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Pesanan</h6>
                            <h3 class="mb-0 fw-bold">{{ $totalPesanan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Pesanan Baru</h6>
                            <h3 class="mb-0 fw-bold">{{ $pesananPending }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-spinner"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Diproses</h6>
                            <h3 class="mb-0 fw-bold">{{ $pesananDiproses }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-truck"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Dikirim</h6>
                            <h3 class="mb-0 fw-bold">{{ $pesananDikirim }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('mitra.pesanan.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Filter Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pesanan Baru</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <a href="{{ route('mitra.pesanan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo me-2"></i>Reset Filter
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Pesanan -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-list me-2 text-primary"></i>Daftar Pesanan
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanans as $pesanan)
                        <tr>
                            <td>
                                <span class="badge bg-secondary">#{{ $pesanan->id }}</span>
                            </td>
                            <td>{{ $pesanan->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <div>
                                    <strong>{{ $pesanan->user->name }}</strong><br>
                                    <small class="text-muted">{{ $pesanan->user->email }}</small>
                                </div>
                            </td>
                            <td>{{ $pesanan->orderItems->count() }} item</td>
                            <td class="fw-bold">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            <td>
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
                                <span class="badge bg-{{ $config['class'] }}">
                                    <i class="fas fa-{{ $config['icon'] }} me-1"></i>{{ $config['text'] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('mitra.pesanan.show', $pesanan->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada pesanan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($pesanans->hasPages())
        <div class="card-footer bg-white">
            {{ $pesanans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
