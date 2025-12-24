<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WFA Report System - Sistem Laporan Kerja Work From Anywhere">
    <title>{{ $page_title ?? 'Login - WFA Report System' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Vite CSS & JS (includes FontAwesome, Toastr from npm) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding (Hidden on mobile) -->
        <div
            class="hidden lg:flex lg:w-1/2 xl:w-3/5 bg-gradient-to-br from-blue-600 via-purple-600 to-purple-700 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs>
                        <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>

            <!-- Floating Shapes -->
            <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full blur-xl animate-pulse"></div>
            <div class="absolute bottom-32 right-20 w-48 h-48 bg-white/10 rounded-full blur-2xl animate-pulse"
                style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/3 w-24 h-24 bg-white/10 rounded-full blur-lg animate-pulse"
                style="animation-delay: 0.5s;"></div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center items-center w-full px-12 text-white">
                <!-- Logo -->
                <div class="mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="WFA Report Logo"
                        class="w-32 h-32 object-contain drop-shadow-2xl">
                </div>

                <h1 class="text-4xl xl:text-5xl font-bold text-center mb-4">
                    WFA Report System
                </h1>
                <p class="text-xl xl:text-2xl text-blue-100 text-center mb-8 max-w-md">
                    Sistem Laporan Kerja Work From Anywhere
                </p>

                <!-- Features -->
                <div class="grid grid-cols-1 gap-4 max-w-sm">
                    <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                        <span class="text-sm">Buat laporan harian dengan mudah</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                        <span class="text-sm">Approval cepat dari supervisor</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-white"></i>
                        </div>
                        <span class="text-sm">Monitor produktivitas tim</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 xl:w-2/5 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="WFA Report Logo" class="w-20 h-20 mx-auto mb-4">
                    <h1 class="text-2xl font-bold text-gray-900">WFA Report System</h1>
                    <p class="text-gray-600 text-sm">Sistem Laporan Kerja WFA</p>
                </div>

                <!-- Login Card -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang!</h2>
                        <p class="text-gray-600 mt-2">Silakan login ke akun Anda</p>
                    </div>

                    @yield('content')
                </div>

                <!-- Footer -->
                <div class="text-center mt-8">
                    <p class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} WFA Report System. All rights reserved.
                    </p>
                </div>
            </div>
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

                @if($errors->any())
                    @foreach($errors->all() as $error)
                        toastr.error("{{ $error }}");
                    @endforeach
                @endif
            }
        });
    </script>

    @stack('scripts')
</body>

</html>