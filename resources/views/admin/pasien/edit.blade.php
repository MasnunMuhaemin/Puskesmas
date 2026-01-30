@extends('layouts.app')

@section('title', 'Edit Pasien: ' . $pasien->nama)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Data Pasien</h1>
            <p class="text-gray-600 dark:text-white">Pembaruan data untuk: <strong>{{ $pasien->nama }}</strong></p>
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
        <form action="{{ route(Auth::user()->role . '.pasien.update', $pasien->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIK Field (Read Only or Informational if NIK shouldn't change, but here allowed with validation) -->
                <div class="space-y-2">
                    <label for="nik" class="text-sm font-bold text-gray-700 dark:text-white">NIK (Nomor Induk Kependudukan)</label>
                    <input 
                        type="text" 
                        id="nik" 
                        name="nik" 
                        value="{{ old('nik', $pasien->nik) }}"
                        maxlength="16"
                        class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white"
                        required
                    >
                </div>

                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label for="nama" class="text-sm font-bold text-gray-700 dark:text-white">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        value="{{ old('nama', $pasien->nama) }}"
                        class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white"
                        required
                    >
                </div>

                <!-- Tanggal Lahir -->
                <div class="space-y-2">
                    <label for="tanggal_lahir" class="text-sm font-bold text-gray-700 dark:text-white">Tanggal Lahir</label>
                    <input 
                        type="date" 
                        id="tanggal_lahir" 
                        name="tanggal_lahir" 
                        value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}"
                        class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white"
                        required
                    >
                </div>

                <!-- Alamat Section -->
                <div class="md:col-span-2 space-y-2">
                    <label for="alamat" class="text-sm font-bold text-gray-700 dark:text-white">Alamat Lengkap</label>
                    <textarea 
                        id="alamat" 
                        name="alamat" 
                        rows="3" 
                        class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white"
                        required
                    >{{ old('alamat', $pasien->alamat) }}</textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-gray-700">
                <p class="text-xs text-gray-500 italic">*Pastikan data NIK sudah benar sebelum menyimpan perubahan.</p>
                <div class="flex space-x-3">
                    <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-0.5">
                        Update Data Pasien
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
