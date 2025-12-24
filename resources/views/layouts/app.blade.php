<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page_title ?? 'WFA Report System' }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: true }">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 text-white shadow-xl sidebar-transition lg:translate-x-0 lg:static lg:inset-0">

            <!-- Brand Logo -->
            <div class="flex items-center justify-center h-16 bg-gray-900 border-b border-gray-700">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4">
                    <i class="fas fa-file-alt text-2xl text-blue-400"></i>
                    <span class="text-xl font-bold">WFA Report</span>
                </a>
            </div>

            <!-- Sidebar Content -->
            <div class="flex flex-col h-[calc(100vh-4rem)] overflow-y-auto">
                <!-- User Panel -->
                <div class="p-4 border-b border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-circle text-3xl text-gray-400"></i>
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
                        <span class="ml-3">Dashboard</span>
                    </a>

                    @if(auth()->user()->role === 'superadmin')
                    <a href="{{ route('users.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('users*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3">Manajemen User</span>
                    </a>

                    <a href="{{ route('reports.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('reports*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-clipboard-list w-5"></i>
                        <span class="ml-3">Semua Laporan</span>
                    </a>
                    @else
                    <a href="{{ route('my.reports.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('my-reports*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-clipboard-list w-5"></i>
                        <span class="ml-3">Laporan Saya</span>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('profile*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-user-cog w-5"></i>
                        <span class="ml-3">Profil Saya</span>
                    </a>
                    @endif
                </nav>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen lg:ml-0">
            <!-- Top Navbar -->
            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Desktop Sidebar Toggle -->
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="hidden lg:block p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Right Side Items -->
                    <div class="flex items-center space-x-4">
                        <!-- Current Date -->
                        <div class="hidden md:flex items-center text-sm text-gray-600">
                            <i class="far fa-calendar mr-2"></i>
                            <span>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                        </div>

                        <!-- Logout Button -->
                        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
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
                    <strong>&copy; 2025 WFA Report System.</strong> All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="!sidebarOpen" @click="sidebarOpen = true"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden" style="display: none;">
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Toastr Configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000",
        };

        // Display Flash Messages
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