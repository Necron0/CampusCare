<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Mitra CampusCare</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--primary-gradient);
            color: white;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h4 {
            font-weight: bold;
            margin: 10px 0 5px 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left: 4px solid white;
        }

        .sidebar-menu a i {
            width: 30px;
            font-size: 18px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-wrapper {
            padding: 30px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(var(--sidebar-width) * -1);
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }

        /* Card Hover Effect */
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }

        /* User Dropdown */
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-clinic-medical fa-3x mb-2"></i>
            <h4>Mitra Panel</h4>
            <small>{{ Auth::user()->mitra->nama_apotek }}</small>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('mitra.dashboard') }}" class="{{ request()->routeIs('mitra.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('mitra.obat.index') }}" class="{{ request()->routeIs('mitra.obat.*') ? 'active' : '' }}">
                <i class="fas fa-pills"></i>
                <span>Manajemen Obat</span>
            </a>
            <a href="{{ route('mitra.promosi.index') }}" class="{{ request()->routeIs('mitra.promosi.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i>
                <span>Promosi</span>
            </a>
            <a href="{{ route('mitra.pesanan.index') }}" class="{{ request()->routeIs('mitra.pesanan.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Pesanan</span>
            </a>
            <hr style="border-color: rgba(255,255,255,0.1); margin: 20px;">

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div>
                <button class="btn btn-link d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 d-none d-md-block">@yield('title', 'Dashboard')</h5>
            </div>

            <div class="topbar">
                <div>
                <button class="btn btn-link d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 d-none d-md-block">@yield('title', 'Dashboard')</h5>
            </div>

                <div class="d-flex align-items-center gap-3">
                    <!-- NOTIFIKASI BELL - TAMBAH INI -->
                    <!-- SESUDAH (dengan teks "Notifikasi") -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary position-relative d-flex align-items-center gap-2" type="button" id="notifDropdown" data-bs-toggle="dropdown" onclick="loadNotifikasi()">
                        <i class="fas fa-bell"></i>
                        <span class="d-none d-md-inline">Notifikasi</span>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifBadge" style="display: none;">
                            0
                        </span>
                    </button>

                        <div class="dropdown-menu dropdown-menu-end shadow-lg" style="width: 380px; max-height: 500px;" aria-labelledby="notifDropdown">
                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                                <h6 class="mb-0 fw-bold">Notifikasi</h6>
                                <button class="btn btn-sm btn-link text-decoration-none" onclick="markAllAsRead()">
                                    Tandai Semua Dibaca
                                </button>
                            </div>

                            <!-- Loading -->
                            <div id="notifLoading" class="text-center py-4">
                                <div class="spinner-border spinner-border-sm" role="status"></div>
                                <p class="small text-muted mt-2">Memuat...</p>
                            </div>

                            <!-- Notifikasi List -->
                            <div id="notifList" style="max-height: 400px; overflow-y: auto;"></div>

                            <!-- Footer -->
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('mitra.notifikasi.index') }}" class="dropdown-item text-center text-primary small fw-bold">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                    </div>

                    <!-- User Dropdown (yang sudah ada) -->
                    <div class="user-dropdown">
                        <!-- ... kode user dropdown yang sudah ada ... -->
                    </div>
                </div>
            </div>

            <!-- JavaScript untuk Notifikasi -->
            <script>
            let notifInterval;

            // Load notifikasi saat dropdown dibuka
            function loadNotifikasi() {
                document.getElementById('notifLoading').style.display = 'block';
                document.getElementById('notifList').innerHTML = '';

                fetch('{{ route('mitra.notifikasi.get') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('notifLoading').style.display = 'none';
                        renderNotifikasi(data.notifikasis);
                        updateBadge(data.unread_count);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('notifLoading').style.display = 'none';
                    });
            }

            // Render notifikasi
            function renderNotifikasi(notifikasis) {
                const container = document.getElementById('notifList');

                if (notifikasis.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-4">
                            <i class="fas fa-bell-slash fa-2x text-muted"></i>
                            <p class="text-muted small mt-2">Tidak ada notifikasi</p>
                        </div>
                    `;
                    return;
                }

                container.innerHTML = notifikasis.map(notif => {
                    const iconColors = {
                        'pesanan_baru': 'primary',
                        'pertanyaan_obat': 'info',
                        'pesanan_dibatalkan': 'danger',
                        'review_baru': 'warning',
                        'stok_rendah': 'warning',
                        'promosi_berakhir': 'secondary'
                    };

                    const icons = {
                        'pesanan_baru': 'shopping-cart',
                        'pertanyaan_obat': 'question-circle',
                        'pesanan_dibatalkan': 'times-circle',
                        'review_baru': 'star',
                        'stok_rendah': 'exclamation-triangle',
                        'promosi_berakhir': 'clock'
                    };

                    const bgClass = notif.dibaca ? '' : 'bg-light';
                    const color = iconColors[notif.type] || 'secondary';
                    const icon = icons[notif.type] || 'bell';
                    const link = notif.link ? `href="${notif.link}"` : `onclick="markAsRead(${notif.id})"`;

                    return `
                        <a ${link} class="dropdown-item ${bgClass} px-3 py-3 border-bottom" style="white-space: normal;">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-${color} text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-${icon}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold ${notif.dibaca ? 'text-muted' : ''}">${notif.judul}</h6>
                                    <p class="mb-1 small text-muted">${notif.pesan}</p>
                                    <small class="text-muted">${formatTanggal(notif.created_at)}</small>
                                </div>
                            </div>
                        </a>
                    `;
                }).join('');
            }

            // Update badge counter
            function updateBadge(count) {
                const badge = document.getElementById('notifBadge');
                if (count > 0) {
                    badge.textContent = count > 99 ? '99+' : count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }

            // Mark as read
            function markAsRead(id) {
                fetch(`/mitra/notifikasi/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(() => loadNotifikasi());
            }

            // Mark all as read
            function markAllAsRead() {
                fetch('{{ route('mitra.notifikasi.mark-all-read') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loadNotifikasi();
                });
            }

            // Format tanggal
            function formatTanggal(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diff = Math.floor((now - date) / 1000); // detik

                if (diff < 60) return 'Baru saja';
                if (diff < 3600) return `${Math.floor(diff / 60)} menit lalu`;
                if (diff < 86400) return `${Math.floor(diff / 3600)} jam lalu`;
                if (diff < 604800) return `${Math.floor(diff / 86400)} hari lalu`;

                return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
            }

            // Auto refresh notifikasi setiap 30 detik
            document.addEventListener('DOMContentLoaded', function() {
                // Load pertama kali
                loadNotifikasi();

                // Auto refresh
                notifInterval = setInterval(() => {
                    fetch('{{ route('mitra.notifikasi.get') }}')
                        .then(response => response.json())
                        .then(data => updateBadge(data.unread_count));
                }, 30000); // 30 detik
            });
            </script>

            <style>
            .dropdown-item {
                transition: background-color 0.2s;
            }

            .dropdown-item:hover {
                background-color: #f8f9fa !important;
            }

            #notifList::-webkit-scrollbar {
                width: 6px;
            }

            #notifList::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 3px;
            }
            </style>

            <div class="user-dropdown">
                <div class="dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="d-none d-md-block text-start">
                            <div class="small">{{ Auth::user()->name }}</div>
                            <div class="small text-muted">{{ Auth::user()->email }}</div>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Toggle for Mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>

    @stack('scripts')
</body>
</html>
