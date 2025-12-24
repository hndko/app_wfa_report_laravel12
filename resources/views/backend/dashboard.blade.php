@extends('layouts.app')

@section('content')
@if(auth()->user()->role === 'superadmin')
<!-- SUPERADMIN DASHBOARD -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Users Card -->
    <div
        class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Total User</p>
                <h3 class="text-3xl font-bold">{{ $total_users }}</h3>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-users text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Active Users Card -->
    <div
        class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-1">User Aktif</p>
                <h3 class="text-3xl font-bold">{{ $active_users }}</h3>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-user-check text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Reports Card -->
    <div
        class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-medium mb-1">Pending Approval</p>
                <h3 class="text-3xl font-bold">{{ $pending_reports }}</h3>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-clock text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Today Reports Card -->
    <div
        class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium mb-1">Laporan Hari Ini</p>
                <h3 class="text-3xl font-bold">{{ $total_reports_today }}</h3>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-file-alt text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Pending Reports Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-inbox mr-2 text-blue-600"></i>
            Laporan Menunggu Approval
        </h3>
        <a href="{{ route('reports.index') }}?status=submitted"
            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-150">
            Lihat Semua
        </a>
    </div>

    <div class="overflow-x-auto">
        @if($recent_reports->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama
                        User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Department</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Lokasi
                        Kerja</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($recent_reports as $report)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $report->report_date->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $report->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $report->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $report->user->department }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $report->work_location }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('reports.show', $report->id) }}"
                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors duration-150">
                            <i class="fas fa-eye mr-1"></i> Lihat
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500">Tidak ada laporan yang menunggu approval</p>
        </div>
        @endif
    </div>
</div>

@else
<!-- USER DASHBOARD -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Reports Card -->
    <div
        class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Total Laporan</p>
                <h3 class="text-3xl font-bold">{{ $total_reports }}</h3>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-file-alt text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Approved Reports Card -->
    <div
        class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-1">Disetujui</p>
                <h3 class="text-3xl font-bold">{{ $approved_reports }}</h3>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-check-circle text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Reports Card -->
    <div
        class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-medium mb-1">Pending</p>
                <h3 class="text-3xl font-bold">{{ $submitted_reports }}</h3>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-clock text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Rejected Reports Card -->
    <div
        class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-sm font-medium mb-1">Ditolak</p>
                <h3 class="text-3xl font-bold">{{ $rejected_reports }}</h3>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <i class="fas fa-times-circle text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Reports Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div
        class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-history mr-2 text-blue-600"></i>
            Laporan Terbaru Saya
        </h3>
        <a href="{{ route('my.reports.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-150">
            <i class="fas fa-plus mr-2"></i>
            Buat Laporan Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        @if($recent_reports->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Lokasi
                        Kerja</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Lampiran</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($recent_reports as $report)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $report->report_date->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $report->work_location }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $report->attachments_count }} file
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($report->status === 'draft')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                            Draft
                        </span>
                        @elseif($report->status === 'submitted')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                        @elseif($report->status === 'approved')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                            Disetujui
                        </span>
                        @else
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                            Ditolak
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('my.reports.show', $report->id) }}"
                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors duration-150">
                            <i class="fas fa-eye mr-1"></i> Lihat
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-12">
            <i class="fas fa-file-alt text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500 mb-4">Belum ada laporan. Buat laporan pertama Anda!</p>
            <a href="{{ route('my.reports.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-150">
                <i class="fas fa-plus mr-2"></i>
                Buat Laporan Baru
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Reminder Alert -->
@if(!$has_report_today)
<div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg" role="alert">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
        </div>
        <div class="ml-3 flex-1">
            <h5 class="text-sm font-semibold text-yellow-800 mb-1">Reminder!</h5>
            <p class="text-sm text-yellow-700 mb-2">Anda belum membuat laporan untuk hari ini.</p>
            <a href="{{ route('my.reports.create') }}"
                class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs font-medium rounded-md hover:bg-yellow-700 transition-colors duration-150">
                <i class="fas fa-plus mr-1"></i>
                Buat Sekarang
            </a>
        </div>
    </div>
</div>
@endif
@endif
@endsection