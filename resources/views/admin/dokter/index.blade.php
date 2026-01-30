@extends('layouts.app')

@section('title', 'Data Dokter')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Dokter</h1>
            <p class="text-gray-600 dark:text-white">Kelola tenaga medis dan spesialisasi mereka.</p>
        </div>
        <a href="{{ route('admin.dokter.create') }}" class="px-4 py-2 bg-primary text-white rounded-xl font-semibold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Dokter
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Dokter</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Spesialis</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Poli</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($dokters as $dokter)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold mr-3">
                                    {{ strtoupper(substr($dokter->nama, 0, 1)) }}
                                </div>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $dokter->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-white">
                            {{ $dokter->spesialis }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold">
                                {{ $dokter->poli->nama_poli }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="text-blue-600 hover:text-blue-500">Edit</a>
                                <form action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus dokter ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-500">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">Belum ada data dokter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
