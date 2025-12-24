<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title ?? 'Login - WFA Report System' }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-500 via-purple-500 to-purple-700 p-4">
    <div class="w-full max-w-md">
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="text-center py-8 px-6 border-b border-gray-100">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mb-4">
                    <i class="fas fa-file-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">WFA Report System</h3>
                <p class="text-gray-600 text-sm">Sistem Laporan Kerja WFA</p>
            </div>

            <!-- Body -->
            <div class="p-8">
                @yield('content')
            </div>

            <!-- Footer -->
            <div class="text-center py-4 px-6 bg-gray-50 border-t border-gray-100">
                <small class="text-gray-500 text-xs">&copy; 2025 WFA Report System. All rights reserved.</small>
            </div>
        </div>
    </div>

    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000",
        };

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
    </script>

    @stack('scripts')
</body>

</html>