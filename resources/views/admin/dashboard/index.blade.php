@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Admin Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">Target: 100</span>
            </div>
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Pasien</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalPasien ?? 0 }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Dokter</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalDokter ?? 0 }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-50 dark:bg-orange-900/20 rounded-2xl flex items-center justify-center text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Poli</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalPoli ?? 0 }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-50 dark:bg-green-900/20 rounded-2xl flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Pemeriksaan Selesai</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $statusPendaftaran['selesai'] ?? 0 }}</p>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Aktivitas Terbaru</h2>
            <button class="text-sm font-semibold text-primary hover:primary/80">Lihat Semua</button>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                @forelse($aktivitasTerbaru ?? [] as $aktivitas)
                <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 rounded-lg bg-{{ $aktivitas['color'] ?? 'primary' }}/10 flex items-center justify-center text-{{ $aktivitas['color'] ?? 'primary' }} flex-shrink-0">
                        <!-- Icon would go here based on $aktivitas['icon'] -->
                        <div class="w-2 h-2 rounded-full bg-current"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $aktivitas['message'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($aktivitas['time'])->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada aktivitas terbaru.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
