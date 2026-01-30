@extends('layouts.app')

@section('title', 'Petugas Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Petugas Dashboard</h1>
            <p class="text-gray-600 dark:text-white">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('petugas.pendaftaran.create') }}" class="px-4 py-2 bg-primary text-white rounded-xl font-semibold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Pendaftaran Baru
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-gray-500 dark:text-white text-sm font-medium">Antrian Hari Ini</h3>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $antrianHariIni }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-gray-500 dark:text-white text-sm font-medium">Pasien Menunggu</h3>
            <p class="text-3xl font-bold text-orange-500 mt-1">{{ $pasienMenunggu }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-gray-500 dark:text-white text-sm font-medium">Total Pasien Terdaftar</h3>
            <p class="text-3xl font-bold text-primary mt-1">{{ $totalPasien }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Patient Search Section -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-center">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Cari Pasien Cepat</h2>
            <form action="{{ route('petugas.pasien.index') }}" method="GET" class="relative">
                <input 
                    type="text" 
                    name="search"
                    placeholder="Masukkan NIK atau Nama Pasien..." 
                    class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-gray-900 dark:text-white"
                >
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>
            <p class="mt-4 text-sm text-gray-500 italic">Tekan enter untuk melihat hasil pencarian lengkap.</p>
        </div>

        <!-- Recent Pendaftaran -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Pendaftaran Terbaru</h2>
            </div>
            <div class="p-6">
                <div class="flow-root">
                    <ul role="list" class="-my-5 divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($recentPendaftaran as $p)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                        {{ substr($p->pasien->nama, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $p->pasien->nama }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        Poli: {{ $p->poli->nama_poli }}
                                    </p>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $p->status == 'menunggu' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/40 dark:text-orange-300' : 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="py-4 text-center text-gray-500 italic">Belum ada pendaftaran hari ini.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="mt-6">
                    <a href="{{ route('petugas.pendaftaran.index') }}" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-xl text-gray-700 dark:text-white dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-all">
                        Lihat Semua Pendaftaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
