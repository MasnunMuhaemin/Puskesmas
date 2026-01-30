<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $pasiens = Pasien::query()
            ->when($search, function($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.pasien.index', compact('pasiens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:pasiens,nik',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date|before:today',
        ], [
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
        ]);

        Pasien::create($validated);

        return redirect()->route(auth()->user()->role . '.pasien.index')
            ->with('success', 'Pasien berhasil didaftarkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pasien $pasien)
    {
        $pasien->load(['pendaftarans.poli', 'rekamMedis.dokter']);
        return view('admin.pasien.show', compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasien $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:pasiens,nik,' . $pasien->id,
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date|before:today',
        ], [
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
        ]);

        $pasien->update($validated);

        return redirect()->route(auth()->user()->role . '.pasien.index')
            ->with('success', 'Data pasien berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()->route(auth()->user()->role . '.pasien.index')
            ->with('success', 'Data pasien berhasil dihapus!');
    }

    /**
     * Search pasien by NIK (AJAX/API)
     */
    public function searchByNik(Request $request)
    {
        $nik = $request->get('nik');
        $pasien = Pasien::where('nik', $nik)->first();
        
        if ($pasien) {
            return response()->json([
                'found' => true,
                'data' => $pasien
            ]);
        }
        
        return response()->json([
            'found' => false,
            'message' => 'Pasien tidak ditemukan'
        ]);
    }

    /**
     * Calculate patient's age
     */
    private function calculateAge($tanggalLahir)
    {
        return \Carbon\Carbon::parse($tanggalLahir)->age;
    }
}
