@extends('layouts.app')

@section('title', 'Tambah Dokter Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Data Dokter</h1>
            <p class="text-gray-600 dark:text-gray-400">Daftarkan tenaga medis baru ke dalam sistem.</p>
        </div>
        <a href="{{ route('admin.dokter.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center font-medium">
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

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 overflow-hidden">
        <form action="{{ route('admin.dokter.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Dokter -->
                <div class="md:col-span-2 space-y-2">
                    <label for="nama" class="text-sm font-bold text-gray-700 dark:text-gray-300">Nama Lengkap Dokter (beserta Gelar)</label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        value="{{ old('nama') }}"
                        placeholder="Contoh: dr. Ahmad Subagyo, Sp.PD"
                        class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner"
                        required
                    >
                </div>

                <!-- Spesialis -->
                <div class="space-y-2">
                    <label for="spesialis" class="text-sm font-bold text-gray-700 dark:text-gray-300">Spesialisasi</label>
                    <input 
                        type="text" 
                        id="spesialis" 
                        name="spesialis" 
                        value="{{ old('spesialis') }}"
                        placeholder="Contoh: Penyakit Dalam, Gigi"
                        class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner"
                        required
                    >
                </div>

                <!-- Poli Selection -->
                <div class="space-y-2">
                    <label for="poli_id" class="text-sm font-bold text-gray-700 dark:text-gray-300">Penempatan Poli</label>
                    <select name="poli_id" id="poli_id" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner">
                        <option value="">-- Pilih Poli --</option>
                        @foreach($polis as $poli)
                            <option value="{{ $poli->id }}" {{ old('poli_id') == $poli->id ? 'selected' : '' }}>
                                {{ $poli->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                <button type="submit" class="px-10 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-1">
                    Simpan Data Dokter
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
