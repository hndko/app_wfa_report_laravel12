@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Profile Information Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-user mr-2 text-blue-600"></i>
                Informasi Profil
            </h3>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil akun Anda</p>
        </div>

        <div class="p-6">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="name" class="form-input pl-10"
                                value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" class="form-input pl-10"
                                value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <!-- NIP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            NIP/NIK <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input type="text" name="nip" class="form-input pl-10" value="{{ old('nip', $user->nip) }}"
                                required>
                        </div>
                    </div>

                    <!-- Position -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jabatan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-briefcase text-gray-400"></i>
                            </div>
                            <input type="text" name="position" class="form-input pl-10"
                                value="{{ old('position', $user->position) }}" required>
                        </div>
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Department/Unit Kerja <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-building text-gray-400"></i>
                            </div>
                            <input type="text" name="department" class="form-input pl-10"
                                value="{{ old('department', $user->department) }}" required>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input type="text" name="phone" class="form-input pl-10"
                                value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-lock mr-2 text-yellow-600"></i>
                Ganti Password
            </h3>
            <p class="text-sm text-gray-500 mt-1">Pastikan menggunakan password yang kuat dan unik</p>
        </div>

        <div class="p-6">
            <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Current Password -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Password Saat Ini <span class="text-red-500">*</span>
                        </label>
                        <div class="relative max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="current_password" class="form-input pl-10"
                                placeholder="Masukkan password saat ini" required>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <input type="password" name="password" class="form-input pl-10"
                                placeholder="Minimal 8 karakter" required>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <input type="password" name="password_confirmation" class="form-input pl-10"
                                placeholder="Ulangi password baru" required>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key mr-2"></i> Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection