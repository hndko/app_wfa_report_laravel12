<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page_title ?? 'WFA Report System' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Vite CSS & JS (includes FontAwesome, Toastr, jQuery from npm) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Sidebar transition */
        .sidebar-collapsed {
            width: 0 !important;
            overflow: hidden;
        }

        .sidebar-wrapper {
            transition: width 0.3s ease-in-out;
        }

        .content-wrapper {
            transition: margin-left 0.3s ease-in-out;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: true, sidebarMobileOpen: false }">
    <div class="min-h-screen flex relative">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarMobileOpen" @click="sidebarMobileOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden" style="display: none;">
        </div>

        <!-- Sidebar -->
        <aside :class="[
                sidebarMobileOpen ? 'translate-x-0' : '-translate-x-full',
                sidebarOpen ? 'lg:w-64' : 'lg:w-0 lg:overflow-hidden'
            ]"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 text-white shadow-xl sidebar-wrapper lg:translate-x-0 lg:static lg:inset-0">

            <!-- Brand Logo -->
            <div class="flex items-center h-16 bg-gray-900 border-b border-gray-700 px-4">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    <span class="text-lg font-bold text-white whitespace-nowrap">WFA Report</span>
                </a>
            </div>

            <!-- Sidebar Content -->
            <div class="flex flex-col h-[calc(100vh-4rem)] overflow-y-auto">
                <!-- User Panel -->
                <div class="p-4 border-b border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1)
                                }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">
                                {{ auth()->user()->role === 'superadmin' ? 'Super Admin' : 'User' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-3 py-4 space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-home w-5"></i>
                        <span class="ml-3 whitespace-nowrap">Dashboard</span>
                    </a>

                    @if(auth()->user()->role === 'superadmin')
                    <a href="{{ route('users.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('users*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3 whitespace-nowrap">Manajemen User</span>
                    </a>

                    <a href="{{ route('reports.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('reports*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-clipboard-list w-5"></i>
                        <span class="ml-3 whitespace-nowrap">Semua Laporan</span>
                    </a>

                    <a href="{{ route('settings.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('settings*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-cog w-5"></i>
                        <span class="ml-3 whitespace-nowrap">Pengaturan</span>
                    </a>
                    @else
                    <a href="{{ route('my.reports.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('my-reports*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-clipboard-list w-5"></i>
                        <span class="ml-3 whitespace-nowrap">Laporan Saya</span>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('profile*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-user-cog w-5"></i>
                        <span class="ml-3 whitespace-nowrap">Profil Saya</span>
                    </a>
                    @endif
                </nav>
            </div>
        </aside>

        <!-- Desktop Sidebar Toggle Button (at the edge) -->
        <button @click="sidebarOpen = !sidebarOpen"
            class="hidden lg:flex fixed z-50 items-center justify-center w-6 h-12 bg-gray-800 hover:bg-gray-700 text-white rounded-r-lg shadow-lg transition-all duration-300 top-1/2 -translate-y-1/2"
            :style="sidebarOpen ? 'left: 256px' : 'left: 0'" :class="sidebarOpen ? 'left-64' : 'left-0'">
            <i class="fas" :class="sidebarOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
        </button>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen content-wrapper">
            <!-- Top Navbar -->
            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarMobileOpen = !sidebarMobileOpen"
                        class="lg:hidden p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-150">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Desktop: Empty spacer -->
                    <div class="hidden lg:block"></div>

                    <!-- Right Side Items -->
                    <div class="flex items-center space-x-4">
                        <!-- Current Date -->
                        <div class="hidden md:flex items-center text-sm text-gray-600">
                            <i class="far fa-calendar mr-2"></i>
                            <span>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                        </div>

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 p-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-semibold">{{ substr(auth()->user()->name, 0, 1)
                                        }}</span>
                                </div>
                                <span class="hidden sm:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50"
                                style="display: none;">
                                @if(auth()->user()->role !== 'superadmin')
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-cog mr-2"></i> Profil
                                </a>
                                @endif
                                <button
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </div>
                        </div>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 lg:p-6">
                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $page_title ?? 'Dashboard' }}</h1>
                </div>

                <!-- Content -->
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-4 lg:px-6">
                <div class="text-sm text-gray-600 text-center">
                    <strong>&copy; {{ date('Y') }} WFA Report System.</strong> All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        // Toastr notifications (toastr is now available from npm via app.js)
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof toastr !== 'undefined') {
                @if(session('success'))
                toastr.success("{{ session('success') }}");
                @endif

                @if(session('error'))
                toastr.error("{{ session('error') }}");
                @endif

                @if(session('info'))
                toastr.info("{{ session('info') }}");
                @endif

                @if(session('warning'))
                toastr.warning("{{ session('warning') }}");
                @endif

                @if($errors->any())
                @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
                @endforeach
                @endif
            }
        });

        // Alpine.js helpers
        document.addEventListener('alpine:init', () => {
            Alpine.data('confirmDelete', () => ({
                confirm(message = 'Apakah Anda yakin ingin menghapus data ini?') {
                    return window.confirm(message);
                }
            }));
        });
    </script>

    @stack('scripts')
</body>

</html>