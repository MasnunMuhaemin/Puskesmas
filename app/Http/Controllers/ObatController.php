<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $obats = Obat::query()
            ->when($search, function($query, $search) {
                return $query->where('nama_obat', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'harga' => 'nullable|integer|min:0',
        ]);

        Obat::create($validated);

        return redirect()->route('admin.obat.index')
            ->with('success', 'Obat berhasil ditambahkan!');
    }

    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'harga' => 'nullable|integer|min:0',
        ]);

        $obat->update($validated);

        return redirect()->route('admin.obat.index')
            ->with('success', 'Obat berhasil diperbarui!');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();
        return redirect()->route('admin.obat.index')
            ->with('success', 'Obat berhasil dihapus!');
    }
}
