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

            <!-- Attachments with Drag & Drop -->
            <div x-data="fileUpload()">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-paperclip mr-1"></i>
                    Lampiran (Screenshot/Foto Bukti Kerja)
                </label>

                <!-- Drop Zone -->
                <div @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false"
                    @drop.prevent="handleDrop($event)"
                    :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-gray-300 bg-gray-50'"
                    class="relative border-2 border-dashed rounded-lg p-6 text-center transition-colors duration-200 cursor-pointer hover:border-blue-400 hover:bg-blue-50"
                    @click="$refs.fileInput.click()">

                    <input type="file" name="attachments[]" x-ref="fileInput" @change="handleFiles($event)" multiple
                        accept="image/*,application/pdf" class="hidden">

                    <div class="space-y-2">
                        <div class="text-gray-400">
                            <i class="fas fa-cloud-upload-alt text-4xl"></i>
                        </div>
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold text-blue-600">Klik untuk upload</span> atau drag & drop file di
                            sini
                        </p>
                        <p class="text-xs text-gray-500">
                            Maksimal 2MB per file. Format: JPG, PNG, PDF
                        </p>
                    </div>
                </div>

                <!-- Preview Grid -->
                <div x-show="files.length > 0" class="mt-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">
                            <i class="fas fa-images mr-1"></i>
                            Preview (<span x-text="files.length"></span> file)
                        </span>
                        <button type="button" @click="clearAll()" class="text-xs text-red-600 hover:text-red-800">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Semua
                        </button>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="relative group">
                                <div
                                    class="aspect-square bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                    <!-- Image Preview -->
                                    <template x-if="file.type.startsWith('image/')">
                                        <img :src="file.preview" class="w-full h-full object-cover">
                                    </template>
                                    <!-- PDF Preview -->
                                    <template x-if="file.type === 'application/pdf'">
                                        <div class="w-full h-full flex flex-col items-center justify-center bg-red-50">
                                            <i class="fas fa-file-pdf text-3xl text-red-500"></i>
                                            <span class="text-xs text-gray-600 mt-1 px-1 truncate w-full text-center"
                                                x-text="file.name"></span>
                                        </div>
                                    </template>
                                </div>
                                <!-- Remove Button -->
                                <button type="button" @click="removeFile(index)"
                                    class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-xs hover:bg-red-600 shadow-md opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-times"></i>
                                </button>
                                <!-- File Size -->
                                <div
                                    class="absolute bottom-1 left-1 bg-black/60 text-white text-xs px-1.5 py-0.5 rounded">
                                    <span x-text="formatSize(file.size)"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
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

@push('scripts')
<script>
    function fileUpload() {
    return {
        dragover: false,
        files: [],

        handleFiles(event) {
            const newFiles = Array.from(event.target.files);
            this.addFiles(newFiles);
        },

        handleDrop(event) {
            this.dragover = false;
            const newFiles = Array.from(event.dataTransfer.files);
            this.addFiles(newFiles);
        },

        addFiles(newFiles) {
            newFiles.forEach(file => {
                // Check file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert(`File "${file.name}" terlalu besar. Maksimal 2MB.`);
                    return;
                }

                // Check file type
                if (!file.type.startsWith('image/') && file.type !== 'application/pdf') {
                    alert(`File "${file.name}" tidak didukung. Hanya JPG, PNG, PDF.`);
                    return;
                }

                // Create preview for images
                const fileObj = {
                    file: file,
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    preview: null
                };

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        fileObj.preview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }

                this.files.push(fileObj);
            });

            // Update the file input with DataTransfer
            this.updateFileInput();
        },

        removeFile(index) {
            this.files.splice(index, 1);
            this.updateFileInput();
        },

        clearAll() {
            this.files = [];
            this.$refs.fileInput.value = '';
        },

        updateFileInput() {
            const dt = new DataTransfer();
            this.files.forEach(f => dt.items.add(f.file));
            this.$refs.fileInput.files = dt.files;
        },

        formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }
    }
}
</script>
@endpush