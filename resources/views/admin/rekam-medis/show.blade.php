@extends('layouts.app')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Pemeriksaan</h1>
            <p class="text-gray-600 dark:text-gray-400">Informasi lengkap medis pasien.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('rekam-medis.print', $rekamMedi->id) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white rounded-xl font-bold hover:bg-gray-200 transition-all flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Resep
            </a>
            <a href="{{ route(Auth::user()->role . '.rekam-medis.index') }}" class="px-4 py-2 text-gray-500 hover:text-gray-700 dark:text-white font-medium flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Patient & Visit Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-center pb-6 border-b border-gray-50 dark:border-gray-700 mb-6">
                    <div class="w-20 h-20 bg-primary/10 text-primary rounded-full mx-auto flex items-center justify-center text-3xl font-black mb-4">
                        {{ substr($rekamMedi->pasien->nama, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $rekamMedi->pasien->nama }}</h3>
                    <p class="text-sm text-gray-500">NIK: {{ $rekamMedi->pasien->nik }}</p>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase">Tanggal Periksa</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($rekamMedi->tanggal_periksa)->format('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase">Poli</span>
                        <span class="text-sm font-bold text-primary">{{ $rekamMedi->dokter->poli->nama_poli }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase">Dokter</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $rekamMedi->dokter->nama }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="space-y-8">
                    <!-- Keluhan -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-black text-primary uppercase tracking-widest flex items-center">
                            <span class="w-6 h-0.5 bg-primary mr-2"></span> Keluhan Utama
                        </h4>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $rekamMedi->keluhan }}</p>
                    </div>

                    <!-- Diagnosa -->
                    <div class="space-y-3 p-6 bg-primary/5 rounded-2xl border border-primary/10">
                        <h4 class="text-sm font-black text-primary uppercase tracking-widest flex items-center">
                            <span class="w-6 h-0.5 bg-primary mr-2"></span> Diagnosa Medis
                        </h4>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $rekamMedi->diagnosa }}</p>
                    </div>

                    <!-- Tindakan -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-black text-primary uppercase tracking-widest flex items-center">
                            <span class="w-6 h-0.5 bg-primary mr-2"></span> Tindakan Medis
                        </h4>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $rekamMedi->tindakan }}</p>
                    </div>

                    <!-- Resep / Obat -->
                    <div class="space-y-4 pt-8 border-t border-gray-100 dark:border-gray-700">
                        <h4 class="text-sm font-black text-primary uppercase tracking-widest flex items-center">
                            <span class="w-6 h-0.5 bg-primary mr-2"></span> E-Resep (Obat & Dosis)
                        </h4>
                        
                        <div class="grid grid-cols-1 gap-3">
                            @forelse($rekamMedi->reseps as $resep)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/40 rounded-2xl border border-gray-100 dark:border-gray-700">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center text-primary shadow-sm">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $resep->obat->nama_obat }}</p>
                                        <p class="text-xs text-gray-500">{{ $resep->aturan_pakai }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-black text-primary">{{ $resep->jumlah }}</span>
                                    <span class="text-[10px] text-gray-400 uppercase font-bold ml-1">{{ $resep->obat->satuan }}</span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-6 bg-gray-50 dark:bg-gray-900/40 rounded-2xl border-2 border-dashed border-gray-100 dark:border-gray-700 text-gray-400 italic text-sm">
                                Tidak ada resep obat yang dikeluarkan.
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
