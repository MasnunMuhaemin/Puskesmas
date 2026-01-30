@extends('layouts.app')

@section('title', 'Dokter Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dokter Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Selamat datang kembali, dok! {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <!-- Next Patient Card -->
    <div class="bg-gradient-to-r from-primary to-primary/80 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">
        <div class="relative z-10">
            <h3 class="text-primary-foreground/80 font-medium mb-2">Pasien Berikutnya</h3>
            <h2 class="text-3xl font-bold mb-4">Budi Setiawan</h2>
            <div class="flex space-x-4">
                <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl text-sm font-medium">Poli Umum</div>
                <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl text-sm font-medium">Antrian: #08</div>
            </div>
            <button class="mt-8 px-6 py-3 bg-white text-primary rounded-xl font-bold shadow-lg hover:bg-gray-50 transition-all flex items-center">
                Mulai Periksa
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
        <div class="absolute top-0 right-0 p-8 opacity-20">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14h-2V9h-2V7h4v10z"/>
            </svg>
        </div>
    </div>

    <!-- Appointment Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 h-96">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h2 class="font-bold text-gray-900 dark:text-white">Jadwal Periksa Hari Ini</h2>
            </div>
            <div class="p-6">
                <!-- Placeholder for list -->
                <p class="text-gray-500 text-center py-12">Belum ada riwayat pemeriksaan hari ini.</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h2 class="font-bold text-gray-900 dark:text-white mb-4">Status Poli</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-2xl">
                    <span class="font-medium text-green-700">Poli Buka</span>
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                </div>
                <div class="p-4 bg-gray-50 rounded-2xl">
                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Total Antrian</p>
                    <p class="text-2xl font-bold text-gray-900">12 Pasien</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
