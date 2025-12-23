@extends('layouts.app')

@section('content')
@if(auth()->user()->role === 'superadmin')
<!-- SUPERADMIN DASHBOARD -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total User</div>
            <div class="stat-value">{{ $total_users }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">User Aktif</div>
            <div class="stat-value">{{ $active_users }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Pending Approval</div>
            <div class="stat-value">{{ $pending_reports }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon info">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Laporan Hari Ini</div>
            <div class="stat-value">{{ $total_reports_today }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-inbox"></i> Laporan Menunggu Approval</h3>
        <a href="{{ route('reports.index') }}?status=submitted" class="btn btn-primary btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body">
        @if($recent_reports->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama User</th>
                        <th>Department</th>
                        <th>Lokasi Kerja</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_reports as $report)
                    <tr>
                        <td>{{ $report->report_date->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $report->user->name }}</strong><br>
                            <small class="text-muted">{{ $report->user->email }}</small>
                        </td>
                        <td>{{ $report->user->department }}</td>
                        <td>{{ $report->work_location }}</td>
                        <td>
                            <a href="{{ route('reports.show', $report->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Tidak ada laporan yang menunggu approval</p>
        </div>
        @endif
    </div>
</div>
@else
<!-- USER DASHBOARD -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Laporan</div>
            <div class="stat-value">{{ $total_reports }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Disetujui</div>
            <div class="stat-value">{{ $approved_reports }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Pending</div>
            <div class="stat-value">{{ $submitted_reports }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon danger">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Ditolak</div>
            <div class="stat-value">{{ $rejected_reports }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-history"></i> Laporan Terbaru Saya</h3>
        <a href="{{ route('my.reports.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Buat Laporan Baru
        </a>
    </div>
    <div class="card-body">
        @if($recent_reports->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Lokasi Kerja</th>
                        <th>Lampiran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_reports as $report)
                    <tr>
                        <td>{{ $report->report_date->format('d/m/Y') }}</td>
                        <td>{{ $report->work_location }}</td>
                        <td>{{ $report->attachments_count }} file</td>
                        <td>
                            @if($report->status === 'draft')
                            <span class="badge badge-secondary">Draft</span>
                            @elseif($report->status === 'submitted')
                            <span class="badge badge-warning">Pending</span>
                            @elseif($report->status === 'approved')
                            <span class="badge badge-success">Disetujui</span>
                            @else
                            <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('my.reports.show', $report->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-file-alt"></i>
            <p>Belum ada laporan. Buat laporan pertama Anda!</p>
            <a href="{{ route('my.reports.create') }}" class="btn btn-primary" style="margin-top: 16px;">
                <i class="fas fa-plus"></i> Buat Laporan Baru
            </a>
        </div>
        @endif
    </div>
</div>

@if(!$has_report_today)
<div class="card" style="border-left: 4px solid var(--warning);">
    <div class="card-body">
        <div style="display: flex; align-items: center; gap: 16px;">
            <i class="fas fa-exclamation-triangle" style="font-size: 32px; color: var(--warning);"></i>
            <div>
                <strong>Reminder:</strong> Anda belum membuat laporan untuk hari ini.
                <a href="{{ route('my.reports.create') }}" class="btn btn-warning btn-sm" style="margin-left: 16px;">
                    <i class="fas fa-plus"></i> Buat Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endif
@endsection