@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header -->
    <div
        class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-file-alt mr-2 text-blue-600"></i>
            Buat Laporan Baru
        </h3>
        <a href="{{ route('my.reports.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-150">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <div class="p-6">
        <form action="{{ route('my.reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                        value="{{ old('report_date', date('Y-m-d')) }}" required>
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
                            value="{{ old('start_time', '08:00') }}" required>
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
                            value="{{ old('end_time', '17:00') }}" required>
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
                        placeholder="Contoh: Rumah, Kantor Cabang, dll." value="{{ old('work_location') }}" required>
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
                        placeholder="Jelaskan kegiatan yang dilakukan..." required>{{ old('activities') }}</textarea>
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
                        placeholder="Jelaskan hasil kerja yang dicapai...">{{ old('results') }}</textarea>
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
                        placeholder="Catatan tambahan jika ada...">{{ old('notes') }}</textarea>
                </div>
            </div>

            <!-- Attachments -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Lampiran (Screenshot/Foto Bukti Kerja)
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