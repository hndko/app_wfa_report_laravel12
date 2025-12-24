@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-clipboard-list mr-2 text-blue-600"></i>
            Semua Laporan
        </h3>
    </div>

    <!-- Export Buttons -->
    <div class="px-6 pt-6 pb-0">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('reports.export.excel', request()->query()) }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-150">
                <i class="fas fa-file-excel mr-2"></i>
                Export Excel
            </a>
            <a href="{{ route('reports.export.pdf', request()->query()) }}"
                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-150">
                <i class="fas fa-file-pdf mr-2"></i>
                Export PDF
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="px-6 py-6">
        <form method="GET" action="{{ route('reports.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- User Filter -->
                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <select name="user_id" class="form-select pl-10">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ ($filters['user_id'] ?? '' )==$user->id ? 'selected' : ''
                                }}>
                                {{ $user->name }} - {{ $user->department }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-tag text-gray-400"></i>
                        </div>
                        <select name="status" class="form-select pl-10">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ ($filters['status'] ?? '' )=='draft' ? 'selected' : '' }}>Draft
                            </option>
                            <option value="submitted" {{ ($filters['status'] ?? '' )=='submitted' ? 'selected' : '' }}>
                                Submitted</option>
                            <option value="approved" {{ ($filters['status'] ?? '' )=='approved' ? 'selected' : '' }}>
                                Approved</option>
                            <option value="rejected" {{ ($filters['status'] ?? '' )=='rejected' ? 'selected' : '' }}>
                                Rejected</option>
                        </select>
                    </div>
                </div>

                <!-- Date From -->
                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar text-gray-400"></i>
                        </div>
                        <input type="date" name="date_from" class="form-input pl-10" placeholder="Dari tanggal"
                            value="{{ $filters['date_from'] ?? '' }}">
                    </div>
                </div>

                <!-- Date To -->
                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar text-gray-400"></i>
                        </div>
                        <input type="date" name="date_to" class="form-input pl-10" placeholder="Sampai tanggal"
                            value="{{ $filters['date_to'] ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="flex gap-3">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-150">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
                <a href="{{ route('reports.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-150">
                    <i class="fas fa-redo mr-2"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Reports Table -->
    <div class="px-6 pb-6">
        @if($reports->count() > 0)
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Lokasi Kerja</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jam
                            Kerja</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reports as $report)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $report->report_date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $report->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $report->user->department }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $report->work_location }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ substr($report->start_time, 0, 5) }} - {{ substr($report->end_time, 0, 5) }}
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
                            <a href="{{ route('reports.show', $report->id) }}"
                                class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors duration-150">
                                <i class="fas fa-eye mr-1"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500">Tidak ada laporan ditemukan</p>
        </div>
        @endif
    </div>
</div>
@endsection