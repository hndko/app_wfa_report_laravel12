@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-alt"></i> Detail Laporan</h3>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-body">
        <!-- User Info -->
        <div style="background: var(--light); padding: 16px; border-radius: 8px; margin-bottom: 24px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                    <label style="font-size: 12px; color: var(--text-light); font-weight: 600;">NAMA USER</label>
                    <p style="margin: 4px 0 0; font-weight: 600;">{{ $report->user->name }}</p>
                </div>
                <div>
                    <label style="font-size: 12px; color: var(--text-light); font-weight: 600;">DEPARTMENT</label>
                    <p style="margin: 4px 0 0;">{{ $report->user->department }}</p>
                </div>
                <div>
                    <label style="font-size: 12px; color: var(--text-light); font-weight: 600;">JABATAN</label>
                    <p style="margin: 4px 0 0;">{{ $report->user->position }}</p>
                </div>
                <div>
                    <label style="font-size: 12px; color: var(--text-light); font-weight: 600;">STATUS</label>
                    <p style="margin: 4px 0 0;">
                        @if($report->status === 'draft')
                        <span class="badge badge-secondary">Draft</span>
                        @elseif($report->status === 'submitted')
                        <span class="badge badge-warning">Pending</span>
                        @elseif($report->status === 'approved')
                        <span class="badge badge-success">Disetujui</span>
                        @else
                        <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Report Details -->
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 24px;">
            <div>
                <label
                    style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">TANGGAL
                    LAPORAN</label>
                <p style="font-size: 16px; color: var(--dark);">{{ $report->report_date->format('d F Y') }}</p>
            </div>

            <div>
                <label
                    style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">JAM
                    KERJA</label>
                <p style="font-size: 16px; color: var(--dark);">{{ substr($report->start_time, 0, 5) }} - {{
                    substr($report->end_time, 0, 5) }}</p>
            </div>

            <div>
                <label
                    style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">LOKASI
                    KERJA</label>
                <p style="font-size: 16px; color: var(--dark);">{{ $report->work_location }}</p>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label
                style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">KEGIATAN</label>
            <p style="font-size: 14px; color: var(--dark); white-space: pre-wrap;">{{ $report->activities }}</p>
        </div>

        @if($report->results)
        <div style="margin-bottom: 24px;">
            <label
                style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">HASIL
                KERJA</label>
            <p style="font-size: 14px; color: var(--dark); white-space: pre-wrap;">{{ $report->results }}</p>
        </div>
        @endif

        @if($report->notes)
        <div style="margin-bottom: 24px;">
            <label
                style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">CATATAN</label>
            <p style="font-size: 14px; color: var(--dark); white-space: pre-wrap;">{{ $report->notes }}</p>
        </div>
        @endif

        <!-- Attachments -->
        @if($report->attachments->count() > 0)
        <div style="margin-bottom: 24px;">
            <label
                style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 12px;">LAMPIRAN
                ({{ $report->attachments->count() }})</label>
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
                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank"
                        style="position: absolute; bottom: 4px; right: 4px; background: var(--primary); color: white; padding: 4px 8px; border-radius: 4px; text-decoration: none; font-size: 12px;">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Approval Info -->
        @if($report->status === 'approved' || $report->status === 'rejected')
        <hr>
        <div style="margin-top: 24px;">
            <h4 style="margin-bottom: 16px;">
                <i class="fas fa-{{ $report->status === 'approved' ? 'check-circle' : 'times-circle' }}"></i>
                {{ $report->status === 'approved' ? 'Informasi Persetujuan' : 'Informasi Penolakan' }}
            </h4>
            <div style="background: var(--light); padding: 16px; border-radius: 8px;">
                <p><strong>Diproses oleh:</strong> {{ $report->approver->name }}</p>
                <p><strong>Tanggal:</strong> {{ $report->approved_at->format('d F Y H:i') }}</p>
                @if($report->rejection_reason)
                <p><strong>Alasan:</strong> {{ $report->rejection_reason }}</p>
                @endif
            </div>
        </div>
        @endif

        <!-- Actions -->
        @if($report->status === 'submitted')
        <hr>
        <div style="margin-top: 24px; display: flex; gap: 12px;">
            <form action="{{ route('reports.approve', $report->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menyetujui laporan ini?')">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Setujui Laporan
                </button>
            </form>

            <button type="button" class="btn btn-danger" onclick="showRejectModal()">
                <i class="fas fa-times"></i> Tolak Laporan
            </button>
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
@if($report->status === 'submitted')
<div id="rejectModal"
    style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 24px; border-radius: 12px; max-width: 500px; width: 90%;">
        <h3 style="margin-bottom: 16px;"><i class="fas fa-times-circle"></i> Tolak Laporan</h3>
        <form action="{{ route('reports.reject', $report->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label required">Alasan Penolakan</label>
                <textarea name="rejection_reason" class="form-control" rows="4"
                    placeholder="Masukkan alasan penolakan..." required style="padding: 12px 14px;"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="hideRejectModal()">Batal</button>
                <button type="submit" class="btn btn-danger">Tolak Laporan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showRejectModal() {
    document.getElementById('rejectModal').style.display = 'flex';
}

function hideRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}
</script>
@endif
@endsection