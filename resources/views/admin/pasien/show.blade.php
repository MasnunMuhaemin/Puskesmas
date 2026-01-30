@extends('layouts.app')

@section('title', 'Detail Pasien: ' . $pasien->nama)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-bold text-2xl">
                {{ strtoupper(substr($pasien->nama, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pasien->nama }}</h1>
                <p class="text-gray-500 font-medium">NIK: {{ $pasien->nik }}</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route(Auth::user()->role . '.pasien.edit', $pasien->id) }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all">
                Edit Profil
            </a>
            <a href="{{ route(Auth::user()->role . '.pasien.index') }}" class="px-5 py-2.5 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition-all">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Patient Info Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-sm font-black text-primary uppercase tracking-widest mb-6">Informasi Personal</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-gray-400 mb-1">Tanggal Lahir / Usia</p>
                        <p class="font-bold text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d F Y') }} 
                            ({{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun)
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-1">Alamat Lengkap</p>
                        <p class="font-bold text-gray-900 dark:text-white leading-relaxed">{{ $pasien->alamat }}</p>
                    </div>
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        <p class="text-gray-400 mb-1">Terdaftar Sejak</p>
                        <p class="font-medium text-gray-600 dark:text-gray-400">{{ $pasien->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-primary p-8 rounded-3xl shadow-xl shadow-primary/20 text-white">
                <p class="text-primary-foreground/80 text-xs font-bold uppercase tracking-widest mb-4">Ringkasan Medis</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-2xl font-black">{{ $pasien->rekamMedis->count() }}</p>
                        <p class="text-[10px] font-bold uppercase">Kunjungan</p>
                    </div>
                    <div>
                        <p class="text-2xl font-black">{{ $pasien->pendaftarans->where('status', 'menunggu')->count() }}</p>
                        <p class="text-[10px] font-bold uppercase">Antrian Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Timeline -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="font-bold text-gray-900 dark:text-white">Riwayat Pemeriksaan</h3>
                </div>
                
                <div class="p-0">
                    @forelse($pasien->rekamMedis as $rekam)
                    <div class="p-6 border-b border-gray-50 dark:border-gray-700 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black uppercase rounded-lg">Check-up</span>
                            <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($rekam->tanggal_periksa)->format('d/m/Y') }}</span>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white mb-1">{{ $rekam->diagnosa }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $rekam->keluhan }}</p>
                        <div class="flex items-center text-xs text-gray-500">
                            <div class="w-6 h-6 rounded-full bg-gray-200 mr-2 flex items-center justify-center font-bold text-[8px] text-gray-600">DR</div>
                            Dokter Pemeriksa: <span class="font-bold ml-1 text-gray-700">{{ $rekam->dokter->nama }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="p-12 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p>Belum ada riwayat rekam medis untuk pasien ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Pendaftaran -->
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-3xl p-6 border border-dashed border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-bold text-gray-400 mb-4">Pendaftaran Terakhir</h3>
                <div class="space-y-3">
                    @foreach($pasien->pendaftarans->take(3) as $p)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold">{{ $p->poli->nama_poli }}</p>
                                <p class="text-[10px] text-gray-400">{{ $p->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black uppercase text-gray-400">{{ $p->status }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
