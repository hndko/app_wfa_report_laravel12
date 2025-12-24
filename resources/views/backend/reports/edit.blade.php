@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header -->
    <div
        class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-edit mr-2 text-blue-600"></i>
            Edit Laporan
        </h3>
        <a href="{{ route('my.reports.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-150">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <div class="p-6">
        @if($report->status === 'rejected' && $report->rejection_reason)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-0.5"></i>
                <div>
                    <strong class="text-red-800 font-semibold">Laporan Ditolak</strong>
                    <p class="text-red-700 mt-1">{{ $report->rejection_reason }}</p>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('my.reports.update', $report->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <!-- Report Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Laporan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar text-gray-400"></i>
                    </div>
                    <input type="date" name="report_date" class="form-input pl-10"
                        value="{{ old('report_date', $report->report_date->format('Y-m-d')) }}" required>
                </div>
            </div>

            <!-- Time Range -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jam Mulai <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-clock text-gray-400"></i>
                        </div>
                        <input type="time" name="start_time" class="form-input pl-10"
                            value="{{ old('start_time', substr($report->start_time, 0, 5)) }}" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jam Selesai <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-clock text-gray-400"></i>
                        </div>
                        <input type="time" name="end_time" class="form-input pl-10"
                            value="{{ old('end_time', substr($report->end_time, 0, 5)) }}" required>
                    </div>
                </div>
            </div>

            <!-- Work Location -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Lokasi Kerja WFA <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                    </div>
                    <input type="text" name="work_location" class="form-input pl-10"
                        placeholder="Contoh: Rumah, Kantor Cabang, dll."
                        value="{{ old('work_location', $report->work_location) }}" required>
                </div>
            </div>

            <!-- Activities -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kegiatan/Aktivitas <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute top-3 left-3 pointer-events-none">
                        <i class="fas fa-tasks text-gray-400"></i>
                    </div>
                    <textarea name="activities" class="form-input pl-10" rows="4"
                        placeholder="Jelaskan kegiatan yang dilakukan..."
                        required>{{ old('activities', $report->activities) }}</textarea>
                </div>
            </div>

            <!-- Results -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hasil Kerja</label>
                <div class="relative">
                    <div class="absolute top-3 left-3 pointer-events-none">
                        <i class="fas fa-check-circle text-gray-400"></i>
                    </div>
                    <textarea name="results" class="form-input pl-10" rows="3"
                        placeholder="Jelaskan hasil kerja yang dicapai...">{{ old('results', $report->results) }}</textarea>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                <div class="relative">
                    <div class="absolute top-3 left-3 pointer-events-none">
                        <i class="fas fa-sticky-note text-gray-400"></i>
                    </div>
                    <textarea name="notes" class="form-input pl-10" rows="2"
                        placeholder="Catatan tambahan jika ada...">{{ old('notes', $report->notes) }}</textarea>
                </div>
            </div>

            <!-- Existing Attachments -->
            @if($report->attachments->count() > 0)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Lampiran Saat Ini ({{ $report->attachments->count() }})
                </label>
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
                        <form action="{{ route('my.reports.attachment.delete', $attachment->id) }}" method="POST"
                            class="absolute top-2 right-2" x-data="confirmDelete"
                            @submit.prevent="confirm('Hapus lampiran ini?') && $el.submit()">
                            @csrf
                            <button type="submit"
                                class="bg-red-600 text-white p-2 rounded-md hover:bg-red-700 transition-colors duration-150">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- New Attachments -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tambah Lampiran Baru
                </label>
                <div class="relative">
                    <div class="absolute top-3 left-3 pointer-events-none">
                        <i class="fas fa-paperclip text-gray-400"></i>
                    </div>
                    <input type="file" name="attachments[]" class="form-input pl-10" multiple
                        accept="image/*,application/pdf">
                </div>
                <p class="mt-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Maksimal 2MB per file. Format: JPG, PNG, PDF
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                <button type="submit" name="status" value="draft"
                    class="inline-flex items-center px-5 py-2.5 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-150">
                    <i class="fas fa-save mr-2"></i>
                    Simpan sebagai Draft
                </button>
                <button type="submit" name="status" value="submitted"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-150">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Submit Laporan
                </button>
                <a href="{{ route('my.reports.index') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-400 transition-colors duration-150">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection