@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header -->
    <div
        class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-clipboard-list mr-2 text-blue-600"></i>
            Laporan Saya
        </h3>
        <a href="{{ route('my.reports.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-150">
            <i class="fas fa-plus mr-2"></i>
            Buat Laporan
        </a>
    </div>

    <!-- Filter Section -->
    <div class="px-6 py-6 border-b border-gray-200">
        <form method="GET" action="{{ route('my.reports.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            @if($approval_enabled ?? false)
                            <option value="submitted" {{ ($filters['status'] ?? '' )=='submitted' ? 'selected' : '' }}>
                                Menunggu Approval</option>
                            <option value="rejected" {{ ($filters['status'] ?? '' )=='rejected' ? 'selected' : '' }}>
                                Ditolak</option>
                            @endif
                            <option value="approved" {{ ($filters['status'] ?? '' )=='approved' ? 'selected' : '' }}>
                                Disetujui</option>
                        </select>
                    </div>
                </div>

                <!-- Month Filter -->
                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar text-gray-400"></i>
                        </div>
                        <input type="month" name="month" class="form-input pl-10" value="{{ $filters['month'] ?? '' }}">
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
                <a href="{{ route('my.reports.index') }}"
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
        <div class="overflow-x-auto rounded-lg border border-gray-200 mt-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Lokasi Kerja</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jam
                            Kerja</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Lampiran</th>
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $report->work_location }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ substr($report->start_time, 0, 5) }} - {{ substr($report->end_time, 0, 5) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $report->attachments_count }} file
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('my.reports.show', $report->id) }}"
                                    class="inline-flex items-center px-2 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition-colors duration-150"
                                    title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- PDF Export Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" type="button"
                                        class="inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition-colors duration-150"
                                        title="Export PDF">
                                        <i class="fas fa-file-pdf"></i>
                                        <i class="fas fa-chevron-down ml-1 text-[10px]"></i>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-200"
                                        style="display: none;">
                                        <a href="{{ route('my.reports.pdf.standard', $report->id) }}" target="_blank"
                                            class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-file-alt mr-2 text-gray-400"></i>
                                            Report Standar
                                        </a>
                                        <a href="{{ route('my.reports.pdf.detailed', $report->id) }}" target="_blank"
                                            class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-file-contract mr-2 text-gray-400"></i>
                                            Report Lengkap
                                        </a>
                                    </div>
                                </div>

                                <a href="{{ route('my.reports.edit', $report->id) }}"
                                    class="inline-flex items-center px-2 py-1 bg-yellow-600 text-white text-xs font-medium rounded hover:bg-yellow-700 transition-colors duration-150"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($report->status === 'draft')
                                <form action="{{ route('my.reports.submit', $report->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Yakin ingin submit laporan ini?')">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition-colors duration-150"
                                        title="Submit">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                                <form action="{{ route('my.reports.destroy', $report->id) }}" method="POST"
                                    class="inline-block" x-data="confirmDelete"
                                    @submit.prevent="confirm() && $el.submit()">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition-colors duration-150"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
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
            <p class="text-gray-500 mb-4">Belum ada laporan</p>
            <a href="{{ route('my.reports.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-150">
                <i class="fas fa-plus mr-2"></i>
                Buat Laporan Baru
            </a>
        </div>
        @endif
    </div>
</div>
@endsection