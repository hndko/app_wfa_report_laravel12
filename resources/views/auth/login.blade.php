@extends('layouts.app-auth')

@section('content')
<form action="{{ route('login.post') }}" method="POST">
    @csrf

    <div class="form-group">
        <label class="form-label">Email</label>
        <div class="input-group">
            <i class="fas fa-envelope input-icon"></i>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda"
                value="{{ old('email') }}" required autofocus>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Password</label>
        <div class="input-group">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password Anda" required>
        </div>
    </div>

    <div class="remember-me">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Ingat saya</label>
    </div>

    <button type="submit" class="btn-auth">
        <i class="fas fa-sign-in-alt"></i> Login
    </button>
</form>
@endsection