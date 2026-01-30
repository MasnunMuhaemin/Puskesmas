@extends('layouts.app')

@section('title', 'Riwayat Pemeriksaan Pasien')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Pasien</h1>
            <p class="text-gray-600 dark:text-white">Selamat datang, {{ $user->name }}!</p>
        </div>
        <div class="text-right">
            <p class="text-sm font-bold text-primary">NIK: {{ $user->nik }}</p>
        </div>
    </div>

    @if(!$pasien)
    <div class="bg-orange-50 dark:bg-orange-900/20 border-l-4 border-orange-500 p-6 rounded-2xl">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-bold text-orange-800 dark:text-orange-200">Data Pasien Belum Tertaut</h3>
                <div class="mt-2 text-sm text-orange-700 dark:text-orange-300">
                    <p>Akun Anda belum tertaut dengan data rekam medis di Puskesmas. Pastikan NIK yang Anda daftarkan sesuai dengan data di loket pendaftaran.</p>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Medical History Timeline -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Pemeriksaan Anda</h2>
        </div>
        <div class="p-6">
            <div class="flow-root">
                <ul role="list" class="-mb-8">
                    @forelse($rekamMedis as $rm)
                    <li>
                        <div class="relative pb-8">
                            @if(!$loop->last)
                            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex items-start space-x-3">
                                <div class="relative">
                                    <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                        <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div>
                                        <div class="text-sm">
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $rm->tanggal_periksa->format('d M Y') }}</span>
                                            <span class="ml-2 text-gray-500">• {{ $rm->dokter->nama }} ({{ $rm->dokter->poli->nama_poli }})</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700 dark:text-white space-y-2">
                                        <p><strong class="text-gray-900 dark:text-white">Keluhan:</strong> {{ $rm->keluhan }}</p>
                                        <p><strong class="text-gray-900 dark:text-white">Diagnosa:</strong> <span class="text-primary font-bold">{{ $rm->diagnosa }}</span></p>
                                        
                                        @if($rm->reseps->count() > 0)
                                        <div class="mt-3 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-700">
                                            <p class="text-xs font-black text-primary uppercase tracking-widest mb-2">Resep Obat:</p>
                                            <ul class="space-y-1">
                                                @foreach($rm->reseps as $resep)
                                                <li class="flex items-center text-sm">
                                                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                                    <span class="font-bold text-gray-900 dark:text-white">{{ $resep->obat->nama_obat }}</span>
                                                    <span class="mx-2 text-gray-400">×</span>
                                                    <span class="text-gray-600 dark:text-gray-400">{{ $resep->jumlah }} {{ $resep->obat->satuan }}</span>
                                                    <span class="ml-auto text-xs text-primary font-medium">({{ $resep->aturan_pakai }})</span>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        <div class="bg-gray-50 dark:bg-gray-900/50 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                                            <p><strong class="text-gray-900 dark:text-white">Tindakan Medis:</strong><br>{{ $rm->tindakan }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada riwayat</h3>
                        <p class="mt-1 text-sm text-gray-500">Anda belum melakukan pemeriksaan di Puskesmas ini.</p>
                    </div>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
