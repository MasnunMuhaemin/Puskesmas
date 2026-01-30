@extends('layouts.app')

@section('title', 'Edit Obat')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Perbarui Data Obat</h1>
            <p class="text-gray-600 dark:text-gray-400">Pastikan informasi stok dan harga sudah benar.</p>
        </div>
        <a href="{{ route('admin.obat.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-white flex items-center font-medium">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 dark:text-white">Nama Obat</label>
                <input type="text" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}" placeholder="Contoh: Paracetamol 500mg" required
                    class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-white">Satuan</label>
                    <select name="satuan" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white">
                        @foreach(['tablet', 'sirup', 'kapsul', 'strip', 'box', 'salep', 'ampul'] as $s)
                            <option value="{{ $s }}" {{ old('satuan', $obat->satuan) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-white">Jumlah Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $obat->stok) }}" min="0" required
                        class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 dark:text-white">Harga (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga', $obat->harga) }}" placeholder="0" min="0" required
                    class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white">
            </div>

            <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/25 hover:bg-primary/90 transition-all flex items-center">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
