@extends('layouts.app')

@section('title', 'Edit Rekam Medis')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Rekam Medis</h1>
            <p class="text-gray-600 dark:text-white">Perbarui detail pemeriksaan, diagnosa, dan tindakan medis.</p>
        </div>
        <a href="{{ route(Auth::user()->role . '.rekam-medis.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-white flex items-center font-medium">
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

    <form action="{{ route(Auth::user()->role . '.rekam-medis.update', $rekamMedi->id) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        @method('PUT')
        
        <!-- Left: Patient and Doctor Selection -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-6">
                <h3 class="text-sm font-black text-primary uppercase tracking-widest flex items-center border-b border-gray-50 dark:border-gray-700 pb-4">
                    Subjek Medis
                </h3>
                
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 dark:text-white uppercase">Pasien</label>
                        <select name="pasien_id" class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary transition-all text-sm text-gray-900 dark:text-white">
                            <option value="">-- Pilih Pasien --</option>
                            @foreach($pasiens as $pasien)
                                <option value="{{ $pasien->id }}" {{ old('pasien_id', $rekamMedi->pasien_id) == $pasien->id ? 'selected' : '' }}>
                                    {{ $pasien->nama }} ({{ $pasien->nik }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 dark:text-white uppercase">Dokter Pemeriksa</label>
                        <select name="dokter_id" class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary transition-all text-sm text-gray-900 dark:text-white">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($dokters as $dokter)
                                <option value="{{ $dokter->id }}" {{ old('dokter_id', $rekamMedi->dokter_id) == $dokter->id ? 'selected' : '' }}>
                                    {{ $dokter->nama }} - {{ $dokter->poli->nama_poli }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 dark:text-white uppercase">Tanggal Periksa</label>
                        <input type="date" name="tanggal_periksa" value="{{ old('tanggal_periksa', $rekamMedi->tanggal_periksa instanceof \DateTime ? $rekamMedi->tanggal_periksa->format('Y-m-d') : $rekamMedi->tanggal_periksa) }}" 
                            class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary transition-all text-sm text-gray-900 dark:text-white">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Medical Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-6">
                <h3 class="text-sm font-black text-primary uppercase tracking-widest flex items-center border-b border-gray-50 dark:border-gray-700 pb-4">
                    Catatan Klinis
                </h3>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 dark:text-white">Keluhan Pasien</label>
                        <textarea name="keluhan" rows="3" placeholder="Apa yang dirasakan pasien?" 
                            class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white" required>{{ old('keluhan', $rekamMedi->keluhan) }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 dark:text-white">Diagnosa Medis</label>
                        <input type="text" name="diagnosa" value="{{ old('diagnosa', $rekamMedi->diagnosa) }}" placeholder="Penyakit/Diagnosa dasar" 
                            class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 dark:text-white">Tindakan / Resep Obat</label>
                        <textarea name="tindakan" rows="4" placeholder="Tindakan medis atau resep yang diberikan..." 
                            class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white" required>{{ old('tindakan', $rekamMedi->tindakan) }}</textarea>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                    <button type="submit" class="px-10 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-1">
                        Perbarui Rekam Medis
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
