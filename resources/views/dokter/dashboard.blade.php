@extends('layouts.app')

@section('title', 'Dokter Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dokter Dashboard</h1>
            <p class="text-gray-600 dark:text-white">Selamat datang kembali, dok! {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <!-- Next Patient Card -->
    @php $nextPatient = $antrianSekarang->first(); @endphp
    @if($nextPatient)
    <div class="bg-gradient-to-r from-primary to-primary/80 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">
        <div class="relative z-10">
            <h3 class="text-primary-foreground/80 font-medium mb-2">Pasien Berikutnya</h3>
            <h2 class="text-3xl font-bold mb-4">{{ $nextPatient->pasien->nama }}</h2>
            <div class="flex space-x-4">
                <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl text-sm font-medium">{{ $nextPatient->poli->nama_poli }}</div>
                <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl text-sm font-medium">Jam: {{ $nextPatient->created_at->format('H:i') }}</div>
            </div>
            <a href="{{ route('dokter.rekam-medis.create', ['pasien_id' => $nextPatient->pasien_id]) }}" class="mt-8 inline-flex px-6 py-3 bg-white text-primary rounded-xl font-bold shadow-lg hover:bg-gray-50 transition-all items-center">
                Mulai Periksa
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="absolute top-0 right-0 p-8 opacity-20">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14h-2V9h-2V7h4v10z"/>
            </svg>
        </div>
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border-2 border-dashed border-gray-200 dark:border-gray-700 text-center">
        <p class="text-gray-500 dark:text-white font-medium">Belum ada antrian pasien saat ini.</p>
    </div>
    @endif

    <!-- Appointment Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h2 class="font-bold text-gray-900 dark:text-white">Daftar Tunggu Poli</h2>
            </div>
            <div class="p-0">
                <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($antrianSekarang as $item)
                    <li class="p-6 hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-900 rounded-2xl flex items-center justify-center font-bold text-gray-400">
                                    {{ $item->created_at->format('H:i') }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->pasien->nama }}</p>
                                    <p class="text-xs text-gray-500 dark:text-white">Keluhan: {{ $item->status }}</p>
                                </div>
                            </div>
                            <a href="{{ route('dokter.rekam-medis.create', ['pasien_id' => $item->pasien_id]) }}" class="text-primary font-bold text-sm hover:underline">Periksa</a>
                        </div>
                    </li>
                    @empty
                    <li class="p-12 text-center text-gray-500 dark:text-white italic">Antrian kosong.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h2 class="font-bold text-gray-900 dark:text-white mb-4">Statistik Saya</h2>
                <div class="space-y-4">
                    <div class="p-4 bg-primary/5 rounded-2xl">
                        <p class="text-xs text-gray-500 dark:text-white uppercase font-bold tracking-wider mb-1">Periksa Hari Ini</p>
                        <p class="text-3xl font-black text-primary">{{ $pemeriksaanHariIni }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl">
                        <p class="text-xs text-gray-500 dark:text-white uppercase font-bold tracking-wider mb-1">Total Riwayat Periksa</p>
                        <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalPemeriksaan }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
