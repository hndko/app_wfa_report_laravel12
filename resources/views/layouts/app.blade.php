<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page_title ?? 'WFA Report System' }}</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Toastr CSS for notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-file-alt"></i> WFA Report</h2>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->role === 'superadmin' ? 'Super Admin' : 'User' }}</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>

            @if(auth()->user()->role === 'superadmin')
            <a href="{{ route('users.index') }}" class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Manajemen User</span>
            </a>
            <a href="{{ route('reports.index') }}" class="nav-item {{ request()->is('reports*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i>
                <span>Semua Laporan</span>
            </a>
            @else
            <a href="{{ route('my.reports.index') }}"
                class="nav-item {{ request()->is('my-reports*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i>
                <span>Laporan Saya</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->is('profile*') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i>
                <span>Profil Saya</span>
            </a>
            @endif

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="nav-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h1 class="page-title">{{ $page_title ?? 'Dashboard' }}</h1>
            <div class="topbar-right">
                <span class="topbar-date"><i class="far fa-calendar"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D
                    MMMM YYYY') }}</span>
            </div>
        </div>

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

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
    </script>

    @stack('scripts')
</body>

</html>