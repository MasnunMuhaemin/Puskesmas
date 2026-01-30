@extends('layouts.app')

@section('title', 'Daftar Pendaftaran')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pendaftaran Pasien</h1>
            <p class="text-gray-600 dark:text-white">Kelola antrian dan pendaftaran pasien hari ini.</p>
        </div>
        <a href="{{ route(Auth::user()->role . '.pendaftaran.create') }}" class="px-4 py-2 bg-primary text-white rounded-xl font-semibold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Daftar Pasien
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
        <form action="{{ route(Auth::user()->role . '.pendaftaran.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Status</label>
                <select name="status" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary text-gray-900 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-2 flex items-end">
                <button type="submit" class="w-full md:w-auto px-8 py-2 bg-gray-900 text-white rounded-xl font-semibold hover:bg-black transition-all">Filter</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Poli Tujuan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($pendaftarans as $index => $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                            #{{ $pendaftarans->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item->pasien->nama }}</span>
                                <span class="text-xs text-gray-500">NIK: {{ $item->pasien->nik }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-white">
                            {{ $item->poli->nama_poli }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'menunggu' => 'bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400',
                                    'selesai' => 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400',
                                    'batal' => 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusClasses[$item->status] }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('pendaftaran.update-status', $item->id) }}" method="POST" class="inline">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-xs bg-gray-50 dark:bg-gray-900 border-none rounded-lg focus:ring-primary py-1 text-gray-900 dark:text-white">
                                    <option value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }}>Set Menunggu</option>
                                    <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Set Selesai</option>
                                    <option value="batal" {{ $item->status == 'batal' ? 'selected' : '' }}>Set Batal</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada pendaftaran hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $pendaftarans->links() }}
        </div>
    </div>
</div>
@endsection
