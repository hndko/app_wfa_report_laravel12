@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-plus"></i> Tambah User Baru</h3>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label required">Nama Lengkap</label>
                <div class="input-group">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap"
                        value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Email</label>
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email"
                        value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">NIP/NIK</label>
                <div class="input-group">
                    <i class="fas fa-id-card input-icon"></i>
                    <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP/NIK"
                        value="{{ old('nip') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Jabatan</label>
                <div class="input-group">
                    <i class="fas fa-briefcase input-icon"></i>
                    <input type="text" name="position" class="form-control" placeholder="Masukkan jabatan"
                        value="{{ old('position') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Department/Unit Kerja</label>
                <div class="input-group">
                    <i class="fas fa-building input-icon"></i>
                    <input type="text" name="department" class="form-control" placeholder="Masukkan department"
                        value="{{ old('department') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <div class="input-group">
                    <i class="fas fa-phone input-icon"></i>
                    <input type="text" name="phone" class="form-control" placeholder="Masukkan no. telepon"
                        value="{{ old('phone') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Password</label>
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter"
                        required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Konfirmasi Password</label>
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Ulangi password" required>
                </div>
            </div>

            <div class="card-footer" style="margin: 24px -24px -24px; padding: 16px 24px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection