@extends('layouts.app')

@section('title', 'Pendaftaran Pasien')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pendaftaran Antrian Baru</h1>
            <p class="text-gray-600 dark:text-white">Daftarkan pasien ke poli tujuan hari ini.</p>
        </div>
        <a href="{{ route(Auth::user()->role . '.pendaftaran.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-white flex items-center font-medium">
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
        <form action="{{ route(Auth::user()->role . '.pendaftaran.store') }}" method="POST" class="p-8 space-y-8">
            @csrf

            <!-- Search Pasien Widget (Simple Dropdown for now, can be upgraded to search) -->
            <div class="space-y-4">
                <h3 class="text-sm font-black text-primary uppercase tracking-widest flex items-center">
                    <span class="w-2 h-2 bg-primary rounded-full mr-2"></span> Pilih Pasien
                </h3>
                <div class="relative">
                    <select 
                        name="pasien_id" 
                        id="pasien_id" 
                        required
                        class="block w-full px-4 py-4 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all appearance-none text-gray-900 dark:text-white"
                    >
                        <option value="">-- Pilih Pasien Terdaftar --</option>
                        @foreach($pasiens as $pasien)
                            <option value="{{ $pasien->id }}" {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>
                                {{ $pasien->nik }} - {{ $pasien->nama }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500">Pasien belum terdaftar? <a href="{{ route(Auth::user()->role . '.pasien.create') }}" class="text-primary font-bold hover:underline">Tambah Pasien Baru</a></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Poli Choice -->
                <div class="space-y-4">
                    <h3 class="text-sm font-black text-primary uppercase tracking-widest flex items-center">
                        <span class="w-2 h-2 bg-primary rounded-full mr-2"></span> Unit Layanan (Poli)
                    </h3>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($polis as $poli)
                        <label class="relative flex items-center p-4 cursor-pointer bg-gray-50 dark:bg-gray-900 rounded-2xl border-2 border-transparent has-[:checked]:border-primary has-[:checked]:bg-primary/5 transition-all group">
                            <input type="radio" name="poli_id" value="{{ $poli->id }}" class="hidden" {{ old('poli_id') == $poli->id ? 'selected' : '' }} required>
                            <div class="flex items-center justify-between w-full">
                                <span class="font-bold text-gray-700 dark:text-white group-has-[:checked]:text-primary">{{ $poli->nama_poli }}</span>
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 group-has-[:checked]:border-primary group-has-[:checked]:bg-primary flex items-center justify-center">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Registration Details -->
                <div class="space-y-6">
                    <h3 class="text-sm font-black text-primary uppercase tracking-widest flex items-center">
                        <span class="w-2 h-2 bg-primary rounded-full mr-2"></span> Detail Pendaftaran
                    </h3>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 dark:text-white uppercase">Tanggal Daftar</label>
                        <input type="date" name="tanggal_daftar" value="{{ old('tanggal_daftar', date('Y-m-d')) }}" 
                            class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 dark:text-white uppercase">Status Awal</label>
                        <select name="status" class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white">
                            <option value="menunggu">Menunggu (Antrian)</option>
                            <option value="selesai">Selesai (Langsung Periksa)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                <button type="submit" class="px-10 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-1">
                    Konfirmasi Pendaftaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
