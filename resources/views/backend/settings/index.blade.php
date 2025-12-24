@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-cog mr-2 text-blue-600"></i>
                Pengaturan Sistem
            </h3>
            <p class="text-sm text-gray-500 mt-1">Kelola pengaturan aplikasi</p>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" class="p-6 space-y-8">
            @csrf

            <!-- Report Settings -->
            <div class="border-b border-gray-200 pb-6">
                <h4 class="text-base font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-clipboard-list mr-2 text-gray-500"></i>
                    Pengaturan Laporan
                </h4>

                <!-- Approval Toggle -->
                <div class="flex items-start justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <label class="text-sm font-medium text-gray-900">
                            Fitur Approval Laporan
                        </label>
                        <p class="text-sm text-gray-500 mt-1">
                            Jika diaktifkan, laporan yang disubmit harus disetujui oleh admin terlebih dahulu.
                            Jika dinonaktifkan, laporan langsung disetujui saat disubmit.
                        </p>
                    </div>
                    <div class="ml-4 flex-shrink-0" x-data="{ enabled: {{ $approval_enabled ? 'true' : 'false' }} }">
                        <button type="button" @click="enabled = !enabled"
                            :class="enabled ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <span :class="enabled ? 'translate-x-5' : 'translate-x-0'"
                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                        <input type="hidden" name="approval_enabled" :value="enabled ? '1' : '0'">
                    </div>
                </div>

                <!-- Current Status Info -->
                <div
                    class="mt-4 p-4 rounded-lg {{ $approval_enabled ? 'bg-blue-50 border border-blue-200' : 'bg-green-50 border border-green-200' }}">
                    @if($approval_enabled)
                    <div class="flex items-center">
                        <i class="fas fa-clock text-blue-600 mr-2"></i>
                        <span class="text-sm text-blue-800">
                            <strong>Approval Aktif:</strong> Laporan memerlukan persetujuan admin
                        </span>
                    </div>
                    @else
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <span class="text-sm text-green-800">
                            <strong>Approval Nonaktif:</strong> Laporan langsung disetujui saat submit
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- App Settings -->
            <div>
                <h4 class="text-base font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-globe mr-2 text-gray-500"></i>
                    Pengaturan Umum
                </h4>

                <div class="space-y-4">
                    <!-- App Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Aplikasi</label>
                        <input type="text" name="app_name" class="form-input"
                            value="{{ \App\Models\Setting::get('app_name', 'WFA Report System') }}">
                    </div>

                    <!-- App Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Aplikasi</label>
                        <input type="text" name="app_description" class="form-input"
                            value="{{ \App\Models\Setting::get('app_description', 'Sistem Laporan Kerja Work From Anywhere') }}">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection