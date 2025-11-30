<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CampusCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .tab-button.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <!-- Left Side - Brand -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-8 text-white flex flex-col justify-center">
                <div class="text-center lg:text-left">
                    <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto lg:mx-0 mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold mb-4">CampusCare</h1>
                    <p class="text-blue-100 text-lg">Sistem Kesehatan Terpadu</p>
                    <p class="text-blue-200 mt-2">Universitas Jember</p>

                    <div class="mt-8 space-y-4">
                        <div class="flex items-center text-blue-100">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Layanan kesehatan kampus 24/7</span>
                        </div>
                        <div class="flex items-center text-blue-100">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Konsultasi dengan tenaga profesional</span>
                        </div>
                        <div class="flex items-center text-blue-100">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Pengobatan dan apotek digital</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Options -->
            <div class="p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Selamat Datang</h2>
                    <p class="text-gray-600">Pilih metode login sesuai kebutuhan Anda</p>
                </div>

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm">{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Tab Navigation -->
                <div class="flex space-x-1 mb-6 bg-gray-100 p-1 rounded-xl">
                    <button
                        onclick="switchTab('mahasiswa')"
                        class="tab-button flex-1 py-3 px-4 rounded-lg font-medium text-center transition-all duration-300 active"
                        id="tab-mahasiswa"
                    >
                        Mahasiswa
                    </button>
                    <button
                        onclick="switchTab('mitra')"
                        class="tab-button flex-1 py-3 px-4 rounded-lg font-medium text-center transition-all duration-300"
                        id="tab-mitra"
                    >
                        Mitra
                    </button>
                </div>

                <!-- Mahasiswa Tab Content -->
                <div id="content-mahasiswa" class="tab-content active space-y-6">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Login sebagai Mahasiswa</h3>
                        <p class="text-gray-600 text-sm mb-6">Gunakan akun UNEJ Anda untuk mengakses layanan kesehatan</p>

                        <a href="{{ route('login.google') }}"
                           class="w-full flex items-center justify-center px-6 py-4 border-2 border-gray-300 rounded-xl hover:border-blue-500 transition-all duration-300 hover:shadow-lg bg-white">
                            <svg class="w-6 h-6 mr-3" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="text-gray-700 font-medium">Login dengan Akun UNEJ</span>
                        </a>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-blue-800 text-sm font-medium">Informasi Login Mahasiswa</p>
                                <p class="text-blue-700 text-xs mt-1">
                                    Hanya akun dengan domain <strong>@unej.ac.id</strong> yang dapat login.
                                    Sistem akan otomatis membuat akun baru jika belum terdaftar.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mitra Tab Content -->
                <div id="content-mitra" class="tab-content space-y-6">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Akses sebagai Mitra</h3>
                        <p class="text-gray-600 text-sm mb-6">Login atau daftar untuk mengelola layanan kesehatan</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('mitra.login') }}"
                           class="flex flex-col items-center justify-center p-6 border-2 border-green-200 rounded-xl hover:border-green-500 transition-all duration-300 hover:shadow-lg bg-green-50 text-center">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-1">Login Mitra</h4>
                            <p class="text-gray-600 text-xs">Sudah punya akun mitra?</p>
                        </a>

                        <a href="{{ route('mitra.register') }}"
                           class="flex flex-col items-center justify-center p-6 border-2 border-orange-200 rounded-xl hover:border-orange-500 transition-all duration-300 hover:shadow-lg bg-orange-50 text-center">
                            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-1">Daftar Mitra</h4>
                            <p class="text-gray-600 text-xs">Belum punya akun mitra?</p>
                        </a>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-green-800 text-sm font-medium">Informasi Mitra</p>
                                <p class="text-green-700 text-xs mt-1">
                                    Mitra dapat mendaftar untuk memberikan layanan kesehatan,
                                    konsultasi, atau pengobatan melalui platform CampusCare.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });

            // Show selected tab content
            document.getElementById('content-' + tabName).classList.add('active');

            // Add active class to clicked tab button
            document.getElementById('tab-' + tabName).classList.add('active');
        }

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('active')) {
                        this.style.transform = 'translateY(-2px)';
                    }
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>
