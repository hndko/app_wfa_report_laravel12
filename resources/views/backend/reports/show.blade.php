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
        <a href="{{ route('reports.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-150">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <div class="p-6 space-y-6">
        <!-- User Info -->
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama User</label>
                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $report->user->name }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Department</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $report->user->department }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Jabatan</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $report->user->position }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</label>
                    <p class="mt-1">
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
                    </p>
                </div>
            </div>
        </div>

        <!-- Report Details -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Tanggal Laporan</label>
                <p class="text-lg text-gray-900">{{ $report->report_date->format('d F Y') }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Jam Kerja</label>
                <p class="text-lg text-gray-900">{{ substr($report->start_time, 0, 5) }} - {{ substr($report->end_time,
                    0, 5) }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Lokasi Kerja</label>
                <p class="text-lg text-gray-900">{{ $report->work_location }}</p>
            </div>
        </div>

        <!-- Activities -->
        <div>
            <label class="block text-sm font-semibold text-gray-600 mb-2">Kegiatan</label>
            <p class="text-sm text-gray-900 whitespace-pre-wrap bg-gray-50 p-4 rounded-lg">{{ $report->activities }}</p>
        </div>

        <!-- Results -->
        @if($report->results)
        <div>
            <label class="block text-sm font-semibold text-gray-600 mb-2">Hasil Kerja</label>
            <p class="text-sm text-gray-900 whitespace-pre-wrap bg-gray-50 p-4 rounded-lg">{{ $report->results }}</p>
        </div>
        @endif

        <!-- Notes -->
        @if($report->notes)
        <div>
            <label class="block text-sm font-semibold text-gray-600 mb-2">Catatan</label>
            <p class="text-sm text-gray-900 whitespace-pre-wrap bg-gray-50 p-4 rounded-lg">{{ $report->notes }}</p>
        </div>
        @endif

        <!-- Attachments -->
        @if($report->attachments->count() > 0)
        <div>
            <label class="block text-sm font-semibold text-gray-600 mb-3">Lampiran ({{ $report->attachments->count()
                }})</label>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($report->attachments as $attachment)
                <div class="relative group rounded-lg overflow-hidden border border-gray-200 aspect-square">
                    @if(in_array($attachment->file_type, ['image/jpeg', 'image/png', 'image/jpg']))
                    <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="{{ $attachment->file_name }}"
                        class="w-full h-full object-cover">
                    @else
                    <div class="flex items-center justify-center h-full bg-gray-100">
                        <i class="fas fa-file-pdf text-4xl text-red-500"></i>
                    </div>
                    @endif
                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank"
                        class="absolute bottom-2 right-2 bg-blue-600 text-white p-2 rounded-md text-xs hover:bg-blue-700 transition-colors duration-150">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Approval/Rejection Info -->
        @if($report->status === 'approved' || $report->status === 'rejected')
        <div class="border-t border-gray-200 pt-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i
                    class="fas fa-{{ $report->status === 'approved' ? 'check-circle text-green-600' : 'times-circle text-red-600' }} mr-2"></i>
                {{ $report->status === 'approved' ? 'Informasi Persetujuan' : 'Informasi Penolakan' }}
            </h4>
            <div
                class="bg-{{ $report->status === 'approved' ? 'green' : 'red' }}-50 border border-{{ $report->status === 'approved' ? 'green' : 'red' }}-200 rounded-lg p-4 space-y-2">
                <p class="text-sm"><strong class="font-semibold">Diproses oleh:</strong> {{ $report->approver->name }}
                </p>
                <p class="text-sm"><strong class="font-semibold">Tanggal:</strong> {{ $report->approved_at->format('d F
                    Y H:i') }}</p>
                @if($report->rejection_reason)
                <p class="text-sm"><strong class="font-semibold">Alasan:</strong> {{ $report->rejection_reason }}</p>
                @endif
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        @if($report->status === 'submitted')
        <div class="border-t border-gray-200 pt-6 flex flex-wrap gap-3">
            <form action="{{ route('reports.approve', $report->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menyetujui laporan ini?')">
                @csrf
                <button type="submit"
                    class="inline-flex items-center px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-150">
                    <i class="fas fa-check mr-2"></i>
                    Setujui Laporan
                </button>
            </form>

            <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                class="inline-flex items-center px-6 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors duration-150">
                <i class="fas fa-times mr-2"></i>
                Tolak Laporan
            </button>
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
@if($report->status === 'submitted')
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-times-circle text-red-600 mr-2"></i>
            Tolak Laporan
        </h3>
        <form action="{{ route('reports.reject', $report->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span
                        class="text-red-500">*</span></label>
                <textarea name="rejection_reason" class="form-input" rows="4" placeholder="Masukkan alasan penolakan..."
                    required></textarea>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-150">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-150">
                    Tolak Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection