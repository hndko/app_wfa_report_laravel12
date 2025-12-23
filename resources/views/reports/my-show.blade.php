@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-alt"></i> Detail Laporan</h3>
        <div>
            @if(in_array($report->status, ['draft', 'rejected']))
            <a href="{{ route('my.reports.edit', $report->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            @endif
            <a href="{{ route('my.reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Status Badge -->
        <div style="margin-bottom: 24px;">
            @if($report->status === 'draft')
            <span class="badge badge-secondary" style="font-size: 14px; padding: 8px 16px;">Draft</span>
            @elseif($report->status === 'submitted')
            <span class="badge badge-warning" style="font-size: 14px; padding: 8px 16px;">Menunggu Approval</span>
            @elseif($report->status === 'approved')
            <span class="badge badge-success" style="font-size: 14px; padding: 8px 16px;">Disetujui</span>
            @else
            <span class="badge badge-danger" style="font-size: 14px; padding: 8px 16px;">Ditolak</span>
            @endif
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

        <!-- Rejection Reason -->
        @if($report->status === 'rejected' && $report->rejection_reason)
        <hr>
        <div
            style="margin-top: 24px; background: #fee2e2; padding: 16px; border-radius: 8px; border-left: 4px solid var(--danger);">
            <h4 style="margin-bottom: 12px; color: var(--danger);">
                <i class="fas fa-times-circle"></i> Alasan Penolakan
            </h4>
            <p style="margin: 0;">{{ $report->rejection_reason }}</p>
            <a href="{{ route('my.reports.edit', $report->id) }}" class="btn btn-warning" style="margin-top: 12px;">
                <i class="fas fa-edit"></i> Perbaiki Laporan
            </a>
        </div>
        @endif

        <!-- Approval Info -->
        @if($report->status === 'approved')
        <hr>
        <div
            style="margin-top: 24px; background: #d1fae5; padding: 16px; border-radius: 8px; border-left: 4px solid var(--success);">
            <h4 style="margin-bottom: 12px; color: var(--success);">
                <i class="fas fa-check-circle"></i> Laporan Disetujui
            </h4>
            <p style="margin: 0;">Disetujui pada: {{ $report->approved_at->format('d F Y H:i') }}</p>
        </div>
        @endif
    </div>
</div>
@endsection