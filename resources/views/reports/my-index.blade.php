@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-clipboard-list"></i> Laporan Saya</h3>
        <a href="{{ route('my.reports.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Laporan
        </a>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('my.reports.index') }}" class="filter-section">
            <div class="filter-grid">
                <div class="form-group" style="margin-bottom: 0;">
                    <div class="input-group">
                        <i class="fas fa-tag input-icon"></i>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ ($filters['status'] ?? '' )=='draft' ? 'selected' : '' }}>Draft
                            </option>
                            <option value="submitted" {{ ($filters['status'] ?? '' )=='submitted' ? 'selected' : '' }}>
                                Submitted</option>
                            <option value="approved" {{ ($filters['status'] ?? '' )=='approved' ? 'selected' : '' }}>
                                Approved</option>
                            <option value="rejected" {{ ($filters['status'] ?? '' )=='rejected' ? 'selected' : '' }}>
                                Rejected</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <div class="input-group">
                        <i class="fas fa-calendar input-icon"></i>
                        <input type="month" name="month" class="form-control" value="{{ $filters['month'] ?? '' }}">
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('my.reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="card-body">
        @if($reports->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Lokasi Kerja</th>
                        <th>Jam Kerja</th>
                        <th>Lampiran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->report_date->format('d/m/Y') }}</td>
                        <td>{{ $report->work_location }}</td>
                        <td>{{ substr($report->start_time, 0, 5) }} - {{ substr($report->end_time, 0, 5) }}</td>
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
                            <a href="{{ route('my.reports.show', $report->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(in_array($report->status, ['draft', 'rejected']))
                            <a href="{{ route('my.reports.edit', $report->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                            @if($report->status === 'draft')
                            <form action="{{ route('my.reports.submit', $report->id) }}" method="POST"
                                style="display: inline;" onsubmit="return confirm('Yakin ingin submit laporan ini?')">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                            <form action="{{ route('my.reports.destroy', $report->id) }}" method="POST"
                                style="display: inline;" onsubmit="return confirmDelete()">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $reports->links() }}
        @else
        <div class="empty-state">
            <i class="fas fa-clipboard-list"></i>
            <p>Belum ada laporan</p>
            <a href="{{ route('my.reports.create') }}" class="btn btn-primary" style="margin-top: 16px;">
                <i class="fas fa-plus"></i> Buat Laporan Baru
            </a>
        </div>
        @endif
    </div>
</div>
@endsection