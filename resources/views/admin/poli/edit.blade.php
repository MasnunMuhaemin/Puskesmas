@extends('layouts.app')

@section('title', 'Edit Poli: ' . $poli->nama_poli)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Unit Poli</h1>
            <p class="text-gray-600 dark:text-white">Pembaruan data untuk unit poliklinik.</p>
        </div>
        <a href="{{ route('admin.poli.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-white flex items-center font-medium">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-xl">
        <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 overflow-hidden">
        <form action="{{ route('admin.poli.update', $poli->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label for="nama_poli" class="text-sm font-bold text-gray-700 dark:text-white">Nama Poliklinik</label>
                <input 
                    type="text" 
                    id="nama_poli" 
                    name="nama_poli" 
                    value="{{ old('nama_poli', $poli->nama_poli) }}"
                    class="block w-full px-4 py-4 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all shadow-inner font-semibold text-gray-900 dark:text-white"
                    required
                >
            </div>

            <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                <button type="submit" class="px-10 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-1">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
