@extends('layouts.app')

@section('content')
@if(auth()->user()->role === 'superadmin')
<!-- SUPERADMIN DASHBOARD -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $total_users }}</h3>
                <p>Total User</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $active_users }}</h3>
                <p>User Aktif</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pending_reports }}</h3>
                <p>Pending Approval</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $total_reports_today }}</h3>
                <p>Laporan Hari Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-inbox"></i> Laporan Menunggu Approval</h3>
        <div class="card-tools">
            <a href="{{ route('reports.index') }}?status=submitted" class="btn btn-primary btn-sm">Lihat Semua</a>
        </div>
    </div>
    <div class="card-body p-0">
        @if($recent_reports->count() > 0)
        <table class="table table-hover">
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
        @else
        <div class="text-center p-5 text-muted">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <p>Tidak ada laporan yang menunggu approval</p>
        </div>
        @endif
    </div>
</div>
@else
<!-- USER DASHBOARD -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $total_reports }}</h3>
                <p>Total Laporan</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $approved_reports }}</h3>
                <p>Disetujui</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $submitted_reports }}</h3>
                <p>Pending</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $rejected_reports }}</h3>
                <p>Ditolak</p>
            </div>
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-history"></i> Laporan Terbaru Saya</h3>
        <div class="card-tools">
            <a href="{{ route('my.reports.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Buat Laporan Baru
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        @if($recent_reports->count() > 0)
        <table class="table table-hover">
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
                        <span class="badge bg-secondary">Draft</span>
                        @elseif($report->status === 'submitted')
                        <span class="badge bg-warning">Pending</span>
                        @elseif($report->status === 'approved')
                        <span class="badge bg-success">Disetujui</span>
                        @else
                        <span class="badge bg-danger">Ditolak</span>
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
        @else
        <div class="text-center p-5 text-muted">
            <i class="fas fa-file-alt fa-3x mb-3"></i>
            <p>Belum ada laporan. Buat laporan pertama Anda!</p>
            <a href="{{ route('my.reports.create') }}" class="btn btn-primary mt-2">
                <i class="fas fa-plus"></i> Buat Laporan Baru
            </a>
        </div>
        @endif
    </div>
</div>

@if(!$has_report_today)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <h5><i class="icon fas fa-exclamation-triangle"></i> Reminder!</h5>
    Anda belum membuat laporan untuk hari ini.
    <a href="{{ route('my.reports.create') }}" class="btn btn-warning btn-sm ms-2">
        <i class="fas fa-plus"></i> Buat Sekarang
    </a>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@endif
@endsection