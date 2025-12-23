@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-cog"></i> Edit Profil</h3>
    </div>

    <div class="card-body">
        <!-- Update Profile Form -->
        <h4 style="margin-bottom: 16px;"><i class="fas fa-user"></i> Informasi Profil</h4>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label required">Nama Lengkap</label>
                <div class="input-group">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap"
                        value="{{ old('name', $user->name) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Email</label>
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email"
                        value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">NIP/NIK</label>
                <div class="input-group">
                    <i class="fas fa-id-card input-icon"></i>
                    <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP/NIK"
                        value="{{ old('nip', $user->nip) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Jabatan</label>
                <div class="input-group">
                    <i class="fas fa-briefcase input-icon"></i>
                    <input type="text" name="position" class="form-control" placeholder="Masukkan jabatan"
                        value="{{ old('position', $user->position) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Department/Unit Kerja</label>
                <div class="input-group">
                    <i class="fas fa-building input-icon"></i>
                    <input type="text" name="department" class="form-control" placeholder="Masukkan department"
                        value="{{ old('department', $user->department) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <div class="input-group">
                    <i class="fas fa-phone input-icon"></i>
                    <input type="text" name="phone" class="form-control" placeholder="Masukkan no. telepon"
                        value="{{ old('phone', $user->phone) }}">
                </div>
            </div>

            <div style="margin-top: 16px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>

        <hr style="margin: 32px 0;">

        <!-- Update Password Form -->
        <h4 style="margin-bottom: 16px;"><i class="fas fa-lock"></i> Ganti Password</h4>
        <form action="{{ route('profile.password') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label required">Password Saat Ini</label>
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="current_password" class="form-control"
                        placeholder="Masukkan password saat ini" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Password Baru</label>
                <div class="input-group">
                    <i class="fas fa-key input-icon"></i>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter"
                        required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required">Konfirmasi Password Baru</label>
                <div class="input-group">
                    <i class="fas fa-key input-icon"></i>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Ulangi password baru" required>
                </div>
            </div>

            <div style="margin-top: 16px;">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-key"></i> Ganti Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection