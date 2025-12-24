@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header -->
    <div
        class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-users mr-2 text-blue-600"></i>
            Daftar User
        </h3>
        <a href="{{ route('users.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Tambah User
        </a>
    </div>

    <!-- Filter Section -->
    <div class="px-6 py-6 border-b border-gray-200">
        <form method="GET" action="{{ route('users.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" class="form-input pl-10" placeholder="Cari nama, email, NIP..."
                        value="{{ $filters['search'] ?? '' }}">
                </div>

                <!-- Department -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-building text-gray-400"></i>
                    </div>
                    <select name="department" class="form-select pl-10">
                        <option value="">Semua Department</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ ($filters['department'] ?? '' )==$dept ? 'selected' : '' }}>
                            {{ $dept }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-toggle-on text-gray-400"></i>
                    </div>
                    <select name="status" class="form-select pl-10">
                        <option value="">Semua Status</option>
                        <option value="active" {{ ($filters['status'] ?? '' )=='active' ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="inactive" {{ ($filters['status'] ?? '' )=='inactive' ? 'selected' : '' }}>
                            Non-Aktif</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="px-6 pb-6">
        @if($users->count() > 0)
        <div class="overflow-x-auto rounded-lg border border-gray-200 mt-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NIP
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Department</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-xs font-semibold">{{ substr($user->name, 0, 1)
                                        }}</span>
                                </div>
                                <span class="font-medium text-gray-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->nip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->position }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->department }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->is_active)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                Aktif
                            </span>
                            @else
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                Non-Aktif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex gap-2">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary btn-sm"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('users.toggle.status', $user->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm {{ $user->is_active ? 'btn-secondary' : 'btn-success' }}"
                                        title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline"
                                    x-data="confirmDelete"
                                    @submit.prevent="confirm('Yakin ingin menghapus user ini?') && $el.submit()">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500">Tidak ada user ditemukan</p>
        </div>
        @endif
    </div>
</div>
@endsection