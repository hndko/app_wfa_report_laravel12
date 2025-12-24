@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header -->
    <div
        class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-file-alt mr-2 text-blue-600"></i>
            Detail Laporan
        </h3>
        <div class="flex flex-wrap gap-2">
            @if(in_array($report->status, ['draft', 'rejected']))
            <a href="{{ route('my.reports.edit', $report->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
            @endif
            <a href="{{ route('my.reports.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="p-6 space-y-6">
        <!-- Status Badge -->
        <div>
            @if($report->status === 'draft')
            <span
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                <i class="fas fa-file mr-2"></i> Draft
            </span>
            @elseif($report->status === 'submitted')
            <span
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                <i class="fas fa-clock mr-2"></i> Menunggu Approval
            </span>
            @elseif($report->status === 'approved')
            <span
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                <i class="fas fa-check-circle mr-2"></i> Disetujui
            </span>
            @else
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                <i class="fas fa-times-circle mr-2"></i> Ditolak
            </span>
            @endif
        </div>

        <!-- Report Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tanggal
                    Laporan</label>
                <p class="text-lg text-gray-900">{{ $report->report_date->format('d F Y') }}</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Jam Kerja</label>
                <p class="text-lg text-gray-900">{{ substr($report->start_time, 0, 5) }} - {{ substr($report->end_time,
                    0, 5) }}</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Lokasi
                    Kerja</label>
                <p class="text-lg text-gray-900">{{ $report->work_location }}</p>
            </div>
        </div>

        <!-- Activities -->
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Kegiatan</label>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $report->activities }}</p>
            </div>
        </div>

        <!-- Results -->
        @if($report->results)
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Hasil Kerja</label>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $report->results }}</p>
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($report->notes)
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Catatan</label>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $report->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Attachments -->
        @if($report->attachments->count() > 0)
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                Lampiran ({{ $report->attachments->count() }})
            </label>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($report->attachments as $attachment)
                <div class="relative group rounded-lg overflow-hidden border border-gray-200 aspect-square bg-gray-100">
                    @if(in_array($attachment->file_type, ['image/jpeg', 'image/png', 'image/jpg']))
                    <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="{{ $attachment->file_name }}"
                        class="w-full h-full object-cover">
                    @else
                    <div class="flex items-center justify-center h-full">
                        <i class="fas fa-file-pdf text-4xl text-red-500"></i>
                    </div>
                    @endif
                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank"
                        class="absolute bottom-2 right-2 bg-blue-600 text-white p-2 rounded-lg text-xs hover:bg-blue-700 transition-colors">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Rejection Reason -->
        @if($report->status === 'rejected' && $report->rejection_reason)
        <div class="border-t border-gray-200 pt-6">
            <div class="bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-times-circle text-red-500 text-xl mr-3 mt-0.5"></i>
                    <div>
                        <h4 class="font-semibold text-red-800 mb-2">Alasan Penolakan</h4>
                        <p class="text-red-700">{{ $report->rejection_reason }}</p>
                        <a href="{{ route('my.reports.edit', $report->id) }}"
                            class="inline-flex items-center mt-3 px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-lg hover:bg-yellow-700 transition-colors">
                            <i class="fas fa-edit mr-2"></i> Perbaiki Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Approval Info -->
        @if($report->status === 'approved')
        <div class="border-t border-gray-200 pt-6">
            <div class="bg-green-50 border-l-4 border-green-500 rounded-r-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3 mt-0.5"></i>
                    <div>
                        <h4 class="font-semibold text-green-800 mb-2">Laporan Disetujui</h4>
                        <p class="text-green-700">Disetujui pada: {{ $report->approved_at->format('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection