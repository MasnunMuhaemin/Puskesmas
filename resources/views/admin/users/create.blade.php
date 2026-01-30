@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah User</h1>
            <p class="text-gray-600 dark:text-gray-400">Buat akun sistem baru.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center font-medium">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-xl">
        <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 overflow-hidden" x-data="{ role: '{{ old('role', 'petugas') }}' }">
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner">
                </div>

                <!-- Email -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Email Login</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner">
                </div>

                <!-- Role Selection -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Role Akses</label>
                    <select name="role" x-model="role" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="dokter">Dokter</option>
                        <option value="pasien">Pasien</option>
                    </select>
                </div>

                <!-- NIK (Only for Pasien) -->
                <div class="space-y-2" x-show="role === 'pasien'" x-transition>
                    <label class="text-sm font-bold text-gray-700 dark:text-gray-300">NIK (Wajib untuk Pasien)</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" :required="role === 'pasien'" maxlength="16" class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner font-mono">
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Password</label>
                    <input type="password" name="password" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner">
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner">
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                <button type="submit" class="px-10 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-1">
                    Simpan User Baru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
