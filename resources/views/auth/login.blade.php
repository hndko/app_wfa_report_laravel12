@extends('layouts.app-auth')

@section('content')
<form action="{{ route('login.post') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Email</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda"
                value="{{ old('email') }}" required autofocus>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password Anda" required>
        </div>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Ingat saya</label>
    </div>

    <button type="submit" class="btn btn-gradient w-100 py-2">
        <i class="fas fa-sign-in-alt"></i> Login
    </button>
</form>
@endsection