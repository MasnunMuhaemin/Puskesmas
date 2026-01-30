<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokters = Dokter::with('poli')->latest()->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $polis = Poli::all();
        return view('admin.dokter.create', compact('polis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'poli_id' => 'required|exists:polis,id',
        ]);

        Dokter::create($validated);

        return redirect()->route('dokter.index')
            ->with('success', 'Dokter berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokter $dokter)
    {
        $dokter->load('poli');
        return view('admin.dokter.show', compact('dokter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokter $dokter)
    {
        $polis = Poli::all();
        return view('admin.dokter.edit', compact('dokter', 'polis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokter $dokter)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'poli_id' => 'required|exists:polis,id',
        ]);

        $dokter->update($validated);

        return redirect()->route('dokter.index')
            ->with('success', 'Data dokter berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokter $dokter)
    {
        $dokter->delete();

        return redirect()->route('dokter.index')
            ->with('success', 'Dokter berhasil dihapus!');
    }

    /**
     * Get dokter by poli (AJAX/API)
     */
    public function getByPoli($poliId)
    {
        $dokters = Dokter::where('poli_id', $poliId)->get();
        return response()->json($dokters);
    }
}
