@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-clipboard-list"></i> Semua Laporan</h3>
    </div>

    <!-- Export Buttons -->
    <div class="card-body" style="padding-bottom: 0;">
        <div style="display: flex; gap: 10px; margin-bottom: 20px;">
            <a href="{{ route('reports.export.excel', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('reports.export.pdf', request()->query()) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card-body" style="padding-top: 0;">
        <form method="GET" action="{{ route('reports.index') }}" class="filter-section">
            <div class="filter-grid">
                <div class="form-group" style="margin-bottom: 0;">
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <select name="user_id" class="form-control">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ ($filters['user_id'] ?? '' )==$user->id ? 'selected' : ''
                                }}>
                                {{ $user->name }} - {{ $user->department }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

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
                        <input type="date" name="date_from" class="form-control" placeholder="Dari tanggal"
                            value="{{ $filters['date_from'] ?? '' }}">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <div class="input-group">
                        <i class="fas fa-calendar input-icon"></i>
                        <input type="date" name="date_to" class="form-control" placeholder="Sampai tanggal"
                            value="{{ $filters['date_to'] ?? '' }}">
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Reports Table -->
    <div class="card-body">
        @if($reports->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>User</th>
                        <th>Lokasi Kerja</th>
                        <th>Jam Kerja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->report_date->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $report->user->name }}</strong><br>
                            <small style="color: var(--text-light);">{{ $report->user->department }}</small>
                        </td>
                        <td>{{ $report->work_location }}</td>
                        <td>{{ substr($report->start_time, 0, 5) }} - {{ substr($report->end_time, 0, 5) }}</td>
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
                            <a href="{{ route('reports.show', $report->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
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
            <p>Tidak ada laporan ditemukan</p>
        </div>
        @endif
    </div>
</div>
@endsection