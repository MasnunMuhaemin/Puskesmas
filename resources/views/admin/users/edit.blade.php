@extends('layouts.app')

@section('title', 'Edit User: ' . $user->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit User</h1>
            <p class="text-gray-600 dark:text-white">Pembaruan data akun: <strong>{{ $user->name }}</strong></p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-white flex items-center font-medium">
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

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 overflow-hidden" x-data="{ role: '{{ old('role', $user->role) }}', showPass: false, showConfirm: false }">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-white">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white">
                </div>

                <!-- Email -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-white">Email Login</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white">
                </div>

                <!-- Role Selection -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-white">Role Akses</label>
                    <select name="role" x-model="role" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="dokter">Dokter</option>
                        <option value="pasien">Pasien</option>
                    </select>
                </div>

                <!-- NIK (Only for Pasien) -->
                <div class="space-y-2" x-show="role === 'pasien'" x-transition>
                    <label class="text-sm font-bold text-gray-700 dark:text-white">NIK (Wajib untuk Pasien)</label>
                    <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" :required="role === 'pasien'" maxlength="16" class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner font-mono text-gray-900 dark:text-white">
                </div>

                <div class="md:col-span-2 py-4 border-t border-gray-50 dark:border-gray-700">
                    <p class="text-xs font-bold text-orange-500 uppercase tracking-widest mb-4">Ganti Password (Kosongkan jika tidak ingin ganti)</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 dark:text-white">Password Baru</label>
                            <div class="relative">
                                <input 
                                    :type="showPass ? 'text' : 'password'" 
                                    type="password"
                                    name="password" 
                                    class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white"
                                >
                                <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary transition-colors">
                                    <svg x-show="!showPass" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showPass" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.04m4.066-1.56A10.848 10.848 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-1.563 3.04m-4.5-4.5a3 3 0 11-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 dark:text-white">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input 
                                    :type="showConfirm ? 'text' : 'password'" 
                                    type="password"
                                    name="password_confirmation" 
                                    class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white"
                                >
                                <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary transition-colors">
                                    <svg x-show="!showConfirm" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showConfirm" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.04m4.066-1.56A10.848 10.848 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-1.563 3.04m-4.5-4.5a3 3 0 11-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                <button type="submit" class="px-10 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-1">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
