@extends('layouts.app')

@section('title', 'Petugas Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Petugas Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('pendaftaran.create') }}" class="px-4 py-2 bg-primary text-white rounded-xl font-semibold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center">
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
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Antrian Hari Ini</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">12</p> <!-- Placeholder -->
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Pasien Menunggu</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">5</p> <!-- Placeholder -->
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Pasien Terdaftar</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">48</p> <!-- Placeholder -->
        </div>
    </div>

    <!-- Patient Search Section -->
    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Cari Pasien Cepat</h2>
        <div class="relative">
            <input 
                type="text" 
                placeholder="Masukkan NIK atau Nama Pasien..." 
                class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
            >
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>
@endsection
