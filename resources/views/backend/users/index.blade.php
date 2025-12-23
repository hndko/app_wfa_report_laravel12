@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users"></i> Daftar User</h3>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>

    <!-- Filter Section -->
    <div class="card-body">
        <form method="GET" action="{{ route('users.index') }}" class="filter-section">
            <div class="filter-grid">
                <div class="form-group" style="margin-bottom: 0;">
                    <div class="input-group">
                        <i class="fas fa-search input-icon"></i>
                        <input type="text" name="search" class="form-control" placeholder="Cari nama, email, NIP..."
                            value="{{ $filters['search'] ?? '' }}">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <div class="input-group">
                        <i class="fas fa-building input-icon"></i>
                        <select name="department" class="form-control">
                            <option value="">Semua Department</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ ($filters['department'] ?? '' )==$dept ? 'selected' : '' }}>
                                {{ $dept }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <div class="input-group">
                        <i class="fas fa-toggle-on input-icon"></i>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="active" {{ ($filters['status'] ?? '' )=='active' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="inactive" {{ ($filters['status'] ?? '' )=='inactive' ? 'selected' : '' }}>
                                Non-Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="card-body">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nip }}</td>
                        <td>{{ $user->position }}</td>
                        <td>{{ $user->department }}</td>
                        <td>
                            @if($user->is_active)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-danger">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('users.toggle.status', $user->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                <button type="submit"
                                    class="btn btn-{{ $user->is_active ? 'secondary' : 'success' }} btn-sm"
                                    title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                style="display: inline;"
                                onsubmit="return confirmDelete('Yakin ingin menghapus user ini?')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
        @else
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <p>Tidak ada user ditemukan</p>
        </div>
        @endif
    </div>
</div>
@endsection