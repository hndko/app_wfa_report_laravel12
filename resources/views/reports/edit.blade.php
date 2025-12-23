@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit"></i> Edit Laporan</h3>
        <a href="{{ route('my.reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-body">
        @if($report->status === 'rejected' && $report->rejection_reason)
        <div
            style="background: #fee2e2; border-left: 4px solid var(--danger); padding: 16px; margin-bottom: 24px; border-radius: 4px;">
            <strong style="color: var(--danger);"><i class="fas fa-exclamation-triangle"></i> Laporan Ditolak</strong>
            <p style="margin: 8px 0 0; color: var(--text);">{{ $report->rejection_reason }}</p>
        </div>
        @endif

        <form action="{{ route('my.reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label required">Tanggal Laporan</label>
                <div class="input-group">
                    <i class="fas fa-calendar input-icon"></i>
                    <input type="date" name="report_date" class="form-control"
                        value="{{ old('report_date', $report->report_date->format('Y-m-d')) }}" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label required">Jam Mulai</label>
                    <div class="input-group">
                        <i class="fas fa-clock input-icon"></i>
                        <input type="time" name="start_time" class="form-control"
                            value="{{ old('start_time', substr($report->start_time, 0, 5)) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label required">Jam Selesai</label>
                    <div class="input-group">
                        <i class="fas fa-clock input-icon"></i>
                        <input type="time" name="end_time" class="form-control"
                            value="{{ old('end_time', substr($report->end_time, 0, 5)) }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Lokasi Kerja WFA</label>
                <div class="input-group">
                    <i class="fas fa-map-marker-alt input-icon"></i>
                    <input type="text" name="work_location" class="form-control"
                        placeholder="Contoh: Rumah, Kantor Cabang, dll."
                        value="{{ old('work_location', $report->work_location) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Kegiatan/Aktivitas</label>
                <div class="input-group">
                    <i class="fas fa-tasks input-icon"></i>
                    <textarea name="activities" class="form-control" rows="4"
                        placeholder="Jelaskan kegiatan yang dilakukan..."
                        required>{{ old('activities', $report->activities) }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Hasil Kerja</label>
                <div class="input-group">
                    <i class="fas fa-check-circle input-icon"></i>
                    <textarea name="results" class="form-control" rows="3"
                        placeholder="Jelaskan hasil kerja yang dicapai...">{{ old('results', $report->results) }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Catatan Tambahan</label>
                <div class="input-group">
                    <i class="fas fa-sticky-note input-icon"></i>
                    <textarea name="notes" class="form-control" rows="2"
                        placeholder="Catatan tambahan jika ada...">{{ old('notes', $report->notes) }}</textarea>
                </div>
            </div>

            <!-- Existing Attachments -->
            @if($report->attachments->count() > 0)
            <div class="form-group">
                <label class="form-label">Lampiran Saat Ini ({{ $report->attachments->count() }})</label>
                <div class="image-preview-container">
                    @foreach($report->attachments as $attachment)
                    <div class="image-preview">
                        @if(in_array($attachment->file_type, ['image/jpeg', 'image/png', 'image/jpg']))
                        <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="{{ $attachment->file_name }}">
                        @else
                        <div
                            style="display: flex; align-items: center; justify-content: center; height: 100%; background: var(--light);">
                            <i class="fas fa-file-pdf" style="font-size: 32px; color: var(--danger);"></i>
                        </div>
                        @endif
                        <form action="{{ route('my.reports.attachment.delete', $attachment->id) }}" method="POST"
                            style="display: inline;" onsubmit="return confirmDelete('Hapus lampiran ini?')">
                            @csrf
                            <button type="submit" class="remove-btn">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="form-group">
                <label class="form-label">Tambah Lampiran Baru</label>
                <div class="input-group">
                    <i class="fas fa-paperclip input-icon"></i>
                    <input type="file" name="attachments[]" class="form-control" multiple
                        accept="image/*,application/pdf" onchange="previewImages(this, 'new-preview-container')">
                </div>
                <small style="color: var(--text-light); display: block; margin-top: 4px;">
                    <i class="fas fa-info-circle"></i> Maksimal 2MB per file. Format: JPG, PNG, PDF
                </small>
                <div id="new-preview-container" class="image-preview-container"></div>
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