@extends('layouts.app-auth')

@section('content')
<form action="{{ route('login.post') }}" method="POST" class="space-y-5">
    @csrf

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-envelope text-gray-400"></i>
            </div>
            <input type="email" name="email"
                class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-lock text-gray-400"></i>
            </div>
            <input type="password" name="password"
                class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                placeholder="Masukkan password Anda" required>
        </div>
    </div>

    <div class="flex items-center">
        <input type="checkbox" id="remember" name="remember"
            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
        <label for="remember" class="ml-2 block text-sm text-gray-700">
            Ingat saya
        </label>
    </div>

    <button type="submit" class="btn-gradient w-full py-3 flex items-center justify-center space-x-2">
        <i class="fas fa-sign-in-alt"></i>
        <span>Login</span>
    </button>
</form>
@endsection