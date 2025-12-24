@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header -->
    <div
        class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-user mr-2 text-blue-600"></i>
            Detail User
        </h3>
        <div class="flex gap-2">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="p-6 space-y-8">
        <!-- User Info -->
        <div class="flex items-center space-x-4 mb-6">
            <div
                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                <span class="text-white text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                <p class="text-gray-600">{{ $user->position }}</p>
                @if($user->is_active)
                <span
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 mt-1">
                    <i class="fas fa-check-circle mr-1"></i> Aktif
                </span>
                @else
                <span
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 mt-1">
                    <i class="fas fa-times-circle mr-1"></i> Non-Aktif
                </span>
                @endif
            </div>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                <p class="text-gray-900">{{ $user->email }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">NIP/NIK</label>
                <p class="text-gray-900">{{ $user->nip }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <label
                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Department</label>
                <p class="text-gray-900">{{ $user->department }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">No.
                    Telepon</label>
                <p class="text-gray-900">{{ $user->phone ?: '-' }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Bergabung</label>
                <p class="text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Statistics -->
        <div class="border-t border-gray-200 pt-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-blue-600 mr-2"></i>
                Statistik Laporan
            </h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">Total Laporan</p>
                            <p class="text-2xl font-bold">{{ $user->reports_count }}</p>
                        </div>
                        <i class="fas fa-file-alt text-3xl text-white/30"></i>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-4 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm">Disetujui</p>
                            <p class="text-2xl font-bold">{{ $user->approved_count }}</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-white/30"></i>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg p-4 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm">Pending</p>
                            <p class="text-2xl font-bold">{{ $user->submitted_count }}</p>
                        </div>
                        <i class="fas fa-clock text-3xl text-white/30"></i>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg p-4 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm">Ditolak</p>
                            <p class="text-2xl font-bold">{{ $user->rejected_count }}</p>
                        </div>
                        <i class="fas fa-times-circle text-3xl text-white/30"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        @if($recent_reports->count() > 0)
        <div class="border-t border-gray-200 pt-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-history text-blue-600 mr-2"></i>
                Laporan Terbaru
            </h4>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Tanggal</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Lokasi Kerja</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recent_reports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $report->report_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $report->work_location }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($report->status === 'draft')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">Draft</span>
                                @elseif($report->status === 'submitted')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($report->status === 'approved')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Disetujui</span>
                                @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection