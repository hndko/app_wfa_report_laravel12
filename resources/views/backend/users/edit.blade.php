@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header -->
    <div
        class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-user-edit mr-2 text-blue-600"></i>
            Edit User
        </h3>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="p-6">
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
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
                        <input type="text" name="name" class="form-input pl-10" value="{{ old('name', $user->name) }}"
                            required>
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

            <!-- Password Section -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex items-center mb-4">
                    <i class="fas fa-key text-gray-400 mr-2"></i>
                    <h4 class="text-lg font-medium text-gray-900">Ganti Password</h4>
                </div>
                <p class="text-sm text-gray-500 mb-4">
                    <i class="fas fa-info-circle mr-1"></i>
                    Kosongkan jika tidak ingin mengubah password
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" class="form-input pl-10"
                                placeholder="Minimal 8 karakter">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password_confirmation" class="form-input pl-10"
                                placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Update
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection