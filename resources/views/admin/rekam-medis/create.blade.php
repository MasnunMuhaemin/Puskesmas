@extends('layouts.app')

@section('title', 'Input Rekam Medis')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Formulir Rekam Medis</h1>
            <p class="text-gray-600 dark:text-white">Catat detail pemeriksaan, diagnosa, dan tindakan medis.</p>
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

    <form action="{{ route(Auth::user()->role . '.rekam-medis.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        
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
                                <option value="{{ $pasien->id }}" {{ (old('pasien_id') == $pasien->id || ($selectedPasien && $selectedPasien->id == $pasien->id)) ? 'selected' : '' }}>
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
                                <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                    {{ $dokter->nama }} - {{ $dokter->poli->nama_poli }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 dark:text-white uppercase">Tanggal Periksa</label>
                        <input type="date" name="tanggal_periksa" value="{{ old('tanggal_periksa', date('Y-m-d')) }}" 
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
                        <textarea name="keluhan" rows="2" placeholder="Apa yang dirasakan pasien?" 
                            class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white" required>{{ old('keluhan') }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 dark:text-white">Diagnosa Medis</label>
                        <input type="text" name="diagnosa" value="{{ old('diagnosa') }}" placeholder="Penyakit/Diagnosa dasar" 
                            class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 dark:text-white">Tindakan Medis</label>
                        <textarea name="tindakan" rows="2" placeholder="Tindakan medis yang diberikan..." 
                            class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner text-gray-900 dark:text-white" required>{{ old('tindakan') }}</textarea>
                    </div>

                    <!-- Prescription Section -->
                    <div x-data="{ 
                        items: [],
                        addItem() {
                            this.items.push({ obat_id: '', jumlah: 1, aturan_pakai: '3 x 1 hari' });
                        },
                        removeItem(index) {
                            this.items.splice(index, 1);
                        }
                    }" class="space-y-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-black text-primary uppercase tracking-widest">E-Resep / Obat</h4>
                            <button type="button" @click="addItem()" class="text-xs bg-primary/10 text-primary px-3 py-1.5 rounded-lg font-bold hover:bg-primary/20 transition-all flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Obat
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700 grid grid-cols-1 md:grid-cols-12 gap-4 items-end animate-in fade-in slide-in-from-top-2 duration-300">
                                    <div class="md:col-span-4 space-y-1">
                                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Nama Obat</label>
                                        <select :name="'resep['+index+'][obat_id]'" x-model="item.obat_id" required class="block w-full px-3 py-2 bg-white dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-primary text-sm text-gray-900 dark:text-white">
                                            <option value="">-- Pilih --</option>
                                            @foreach($obats as $obat)
                                                <option value="{{ $obat->id }}">{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-2 space-y-1">
                                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Jumlah</label>
                                        <input type="number" :name="'resep['+index+'][jumlah]'" x-model="item.jumlah" min="1" required class="block w-full px-3 py-2 bg-white dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-primary text-sm text-gray-900 dark:text-white">
                                    </div>
                                    <div class="md:col-span-5 space-y-1">
                                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Aturan Pakai</label>
                                        <input type="text" :name="'resep['+index+'][aturan_pakai]'" x-model="item.aturan_pakai" required class="block w-full px-3 py-2 bg-white dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-primary text-sm text-gray-900 dark:text-white">
                                    </div>
                                    <div class="md:col-span-1 flex justify-end">
                                        <button type="button" @click="removeItem(index)" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            
                            <div x-show="items.length === 0" class="text-center py-6 border-2 border-dashed border-gray-100 dark:border-gray-700 rounded-2xl">
                                <p class="text-xs text-gray-400 italic">Belum ada obat yang ditambahkan ke resep.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                    <button type="submit" class="px-10 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-1">
                        Simpan Rekam Medis
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
