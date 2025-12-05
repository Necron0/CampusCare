<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>@yield('title', 'CampusCare Admin')</title>
    <style>
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        .content-transition {
            transition: margin-left 0.3s ease-in-out;
        }
        .active-menu {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50 h-full font-sans antialiased">

    <!-- Mobile Sidebar Toggle -->
    <button id="sidebarToggle" class="fixed top-4 left-4 z-50 text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 focus:ring-4 focus:ring-blue-200 font-medium rounded-xl text-sm p-3 focus:outline-none inline-flex sm:hidden shadow-lg hover-lift transition-all duration-300">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
        </svg>
    </button>

    <!-- Backdrop for Mobile -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 hidden sm:hidden"></div>

    <!-- Sidebar -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-72 h-screen sidebar-transition -translate-x-full sm:translate-x-0 bg-gradient-to-b from-white to-gray-50/80 backdrop-blur-sm border-r border-gray-200/60 shadow-xl">
        <div class="h-full flex flex-col px-4 py-6 overflow-y-auto">

            <!-- Logo Section -->
            <div class="flex items-center justify-between mb-8 px-2">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">CampusCare</span>
                        <p class="text-xs text-gray-500 mt-0.5">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 space-y-2">
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-3">Main Menu</div>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 hover-lift group transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
                    <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center mr-3 group-[.active-menu]:bg-white/20 transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-blue-600' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/>
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.mitra-management.index') }}" class="flex items-center px-3 py-3 text-gray-700 rounded-xl hover:bg-green-50 hover:text-green-600 hover-lift group transition-all duration-300 {{ request()->routeIs('admin.mitra-management.*') ? 'active-menu' : '' }}">
                    <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center mr-3 group-[.active-menu]:bg-white/20 transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.mitra-management.*') ? 'text-white' : 'text-green-600' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9M9 7h6m-7 3h8"/>
                        </svg>
                    </div>
                    <span class="font-medium">Manajemen Mitra</span>
                </a>

                <a href="{{ route('admin.user-management.index') }}" class="flex items-center px-3 py-3 text-gray-700 rounded-xl hover:bg-purple-50 hover:text-purple-600 hover-lift group transition-all duration-300 {{ request()->routeIs('admin.user-management.*') ? 'active-menu' : '' }}">
                    <div class="w-9 h-9 rounded-lg bg-purple-100 flex items-center justify-center mr-3 group-[.active-menu]:bg-white/20 transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.user-management.*') ? 'text-white' : 'text-purple-600' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Manajemen User</span>
                </a>

                <a href="{{ route('admin.analytics') }}" class="flex items-center px-3 py-3 text-gray-700 rounded-xl hover:bg-orange-50 hover:text-orange-600 hover-lift group transition-all duration-300 {{ request()->routeIs('admin.analytics') ? 'active-menu' : '' }}">
                    <div class="w-9 h-9 rounded-lg bg-orange-100 flex items-center justify-center mr-3 group-[.active-menu]:bg-white/20 transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.analytics') ? 'text-white' : 'text-orange-600' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v3c0 .5523.44772 1 1 1h16c.5523 0 1-.4477 1-1v-3M3 15V6c0-.55228.44772-1 1-1h16c.5523 0 1 .44772 1 1v9M3 15h18M8 15v4m4-4v4m4-4v4"/>
                        </svg>
                    </div>
                    <span class="font-medium">Analitik & Laporan</span>
                </a>
            </nav>

            <!-- User & Logout Section -->
            <div class="pt-6 mt-6 border-t border-gray-200/60 space-y-3">
                <div class="flex items-center px-3 py-2 text-sm text-gray-600">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mr-3 text-white font-semibold text-xs">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500 text-xs truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-3 py-3 text-red-600 rounded-xl hover:bg-red-50 group transition-all duration-300 hover-lift">
                        <div class="w-9 h-9 rounded-lg bg-red-100 flex items-center justify-center mr-3 group-hover:bg-red-500 transition-colors">
                            <svg class="w-5 h-5 text-red-600 group-hover:text-white transition-colors" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                            </svg>
                        </div>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div id="main-content" class="sm:ml-72 content-transition min-h-full bg-gray-50/50">
        @yield('content')
    </div>

    @yield('scripts')
    <script>
        // Sidebar Toggle Functionality
        const sidebar = document.getElementById('logo-sidebar');
        const toggleButton = document.getElementById('sidebarToggle');
        const backdrop = document.getElementById('sidebarBackdrop');
        const mainContent = document.getElementById('main-content');

        function toggleSidebar() {
            const isHidden = sidebar.classList.contains('-translate-x-full');
            sidebar.classList.toggle('-translate-x-full', !isHidden);
            backdrop.classList.toggle('hidden', !isHidden);
            document.body.classList.toggle('overflow-hidden', !isHidden);
        }

        if (toggleButton) {
            toggleButton.addEventListener('click', toggleSidebar);
        }

        if (backdrop) {
            backdrop.addEventListener('click', toggleSidebar);
        }

        // Close sidebar on mobile when clicking a link
        document.querySelectorAll('#logo-sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 640) {
                    toggleSidebar();
                }
            });
        });

        // Add smooth loading animation
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('loaded');
        });
    </script>
</body>
</html>
