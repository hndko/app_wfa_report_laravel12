@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-alt"></i> Buat Laporan Baru</h3>
        <a href="{{ route('my.reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('my.reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label required">Tanggal Laporan</label>
                <div class="input-group">
                    <i class="fas fa-calendar input-icon"></i>
                    <input type="date" name="report_date" class="form-control"
                        value="{{ old('report_date', date('Y-m-d')) }}" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label required">Jam Mulai</label>
                    <div class="input-group">
                        <i class="fas fa-clock input-icon"></i>
                        <input type="time" name="start_time" class="form-control"
                            value="{{ old('start_time', '08:00') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label required">Jam Selesai</label>
                    <div class="input-group">
                        <i class="fas fa-clock input-icon"></i>
                        <input type="time" name="end_time" class="form-control" value="{{ old('end_time', '17:00') }}"
                            required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Lokasi Kerja WFA</label>
                <div class="input-group">
                    <i class="fas fa-map-marker-alt input-icon"></i>
                    <input type="text" name="work_location" class="form-control"
                        placeholder="Contoh: Rumah, Kantor Cabang, dll." value="{{ old('work_location') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Kegiatan/Aktivitas</label>
                <div class="input-group">
                    <i class="fas fa-tasks input-icon"></i>
                    <textarea name="activities" class="form-control" rows="4"
                        placeholder="Jelaskan kegiatan yang dilakukan..." required>{{ old('activities') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Hasil Kerja</label>
                <div class="input-group">
                    <i class="fas fa-check-circle input-icon"></i>
                    <textarea name="results" class="form-control" rows="3"
                        placeholder="Jelaskan hasil kerja yang dicapai...">{{ old('results') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Catatan Tambahan</label>
                <div class="input-group">
                    <i class="fas fa-sticky-note input-icon"></i>
                    <textarea name="notes" class="form-control" rows="2"
                        placeholder="Catatan tambahan jika ada...">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Lampiran (Screenshot/Foto Bukti Kerja)</label>
                <div class="input-group">
                    <i class="fas fa-paperclip input-icon"></i>
                    <input type="file" name="attachments[]" class="form-control" multiple
                        accept="image/*,application/pdf" onchange="previewImages(this, 'preview-container')">
                </div>
                <small style="color: var(--text-light); display: block; margin-top: 4px;">
                    <i class="fas fa-info-circle"></i> Maksimal 2MB per file. Format: JPG, PNG, PDF
                </small>
                <div id="preview-container" class="image-preview-container"></div>
            </div>

            <div class="card-footer" style="margin: 24px -24px -24px; padding: 16px 24px;">
                <button type="submit" name="status" value="draft" class="btn btn-secondary">
                    <i class="fas fa-save"></i> Simpan sebagai Draft
                </button>
                <button type="submit" name="status" value="submitted" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Submit Laporan
                </button>
                <a href="{{ route('my.reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection