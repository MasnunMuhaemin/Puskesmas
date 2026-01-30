@extends('layouts.app')

@section('title', 'Tambah Pasien Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Registrasi Pasien Baru</h1>
            <p class="text-gray-600 dark:text-white">Silakan isi formulir di bawah ini dengan lengkap.</p>
        </div>
        <a href="{{ route(Auth::user()->role . '.pasien.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-white flex items-center font-medium">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-xl">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-bold text-red-800 dark:text-red-400">Terdapat kesalahan input:</h3>
                <ul class="mt-1 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 overflow-hidden">
        <form action="{{ route(Auth::user()->role . '.pasien.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIK Field -->
                <div class="space-y-2">
                    <label for="nik" class="text-sm font-bold text-gray-700 dark:text-white">Nomor Induk Kependudukan (NIK)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="nik" 
                            name="nik" 
                            value="{{ old('nik') }}"
                            placeholder="16 Digit NIK"
                            maxlength="16"
                            class="block w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white"
                            required
                        >
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label for="nama" class="text-sm font-bold text-gray-700 dark:text-white">Nama Lengkap Pasien</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            value="{{ old('nama') }}"
                            placeholder="Masukkan nama sesuai KTP"
                            class="block w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white"
                            required
                        >
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="space-y-2">
                    <label for="tanggal_lahir" class="text-sm font-bold text-gray-700 dark:text-white">Tanggal Lahir</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input 
                            type="date" 
                            id="tanggal_lahir" 
                            name="tanggal_lahir" 
                            value="{{ old('tanggal_lahir') }}"
                            class="block w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white"
                            required
                        >
                    </div>
                </div>

                <!-- Alamat Section (Full Width) -->
                <div class="md:col-span-2 space-y-2">
                    <label for="alamat" class="text-sm font-bold text-gray-700 dark:text-white">Alamat Lengkap</label>
                    <textarea 
                        id="alamat" 
                        name="alamat" 
                        rows="3" 
                        placeholder="Masukkan alamat lengkap RT/RW, Kecamatan, Kota"
                        class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white"
                        required
                    >{{ old('alamat') }}</textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                <button type="reset" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 dark:text-white transition-all">
                    Reset Form
                </button>
                <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-0.5">
                    Simpan Data Pasien
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
