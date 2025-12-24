@extends('layouts.app-auth')

@section('content')
<form action="{{ route('login.post') }}" method="POST" class="space-y-6" x-data="{ showPassword: false }">
    @csrf

    <!-- Email Field -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fas fa-envelope text-gray-400"></i>
            </div>
            <input type="email" name="email"
                class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-900 placeholder-gray-400"
                placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus>
        </div>
    </div>

    <!-- Password Field -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fas fa-lock text-gray-400"></i>
            </div>
            <input :type="showPassword ? 'text' : 'password'" name="password"
                class="block w-full pl-12 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-900 placeholder-gray-400"
                placeholder="Masukkan password Anda" required>
            <button type="button" @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
            </button>
        </div>
    </div>

    <!-- Remember Me -->
    <div class="flex items-center justify-between">
        <label class="flex items-center cursor-pointer">
            <input type="checkbox" name="remember"
                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
        </label>
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center space-x-2">
        <i class="fas fa-sign-in-alt"></i>
        <span>Masuk</span>
    </button>
</form>
@endsection