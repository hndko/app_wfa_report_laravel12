@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user"></i> Detail User</h3>
        <div>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-body">
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 32px;">
            <div>
                <label
                    style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">NAMA
                    LENGKAP</label>
                <p style="font-size: 16px; color: var(--dark);">{{ $user->name }}</p>
            </div>

            <div>
                <label
                    style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">EMAIL</label>
                <p style="font-size: 16px; color: var(--dark);">{{ $user->email }}</p>
            </div>

            <div>
                <label
                    style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">NIP/NIK</label>
                <p style="font-size: 16px; color: var(--dark);">{{ $user->nip }}</p>
            </div>

            <div>
                <label
                    style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">JABATAN</label>
                <p style="font-size: 16px; color: var(--dark);">{{ $user->position }}</p>
            </div>

            <div>
                <label
                    style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">DEPARTMENT</label>
                <p style="font-size: 16px; color: var(--dark);">{{ $user->department }}</p>
            </div>

            <div>
                <label
                    style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">NO.
                    TELEPON</label>
                <p style="font-size: 16px; color: var(--dark);">{{ $user->phone ?: '-' }}</p>
            </div>

            <div>
                <label
                    style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">STATUS</label>
                <p>
                    @if($user->is_active)
                    <span class="badge badge-success">Aktif</span>
                    @else
                    <span class="badge badge-danger">Non-Aktif</span>
                    @endif
                </p>
            </div>

            <div>
                <label
                    style="font-weight: 600; color: var(--text-light); font-size: 13px; display: block; margin-bottom: 8px;">BERGABUNG</label>
                <p style="font-size: 16px; color: var(--dark);">{{ $user->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <hr>

        <h4 style="margin: 24px 0 16px;"><i class="fas fa-chart-bar"></i> Statistik Laporan</h4>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Laporan</div>
                    <div class="stat-value">{{ $user->reports_count }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Disetujui</div>
                    <div class="stat-value">{{ $user->approved_count }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value">{{ $user->submitted_count }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon danger">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Ditolak</div>
                    <div class="stat-value">{{ $user->rejected_count }}</div>
                </div>
            </div>
        </div>

        @if($recent_reports->count() > 0)
        <h4 style="margin: 24px 0 16px;"><i class="fas fa-history"></i> Laporan Terbaru</h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Lokasi Kerja</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_reports as $report)
                    <tr>
                        <td>{{ $report->report_date->format('d/m/Y') }}</td>
                        <td>{{ $report->work_location }}</td>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection