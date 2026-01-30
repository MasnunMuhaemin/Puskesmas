<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $tanggal = $request->get('tanggal');
        
        $rekamMedis = RekamMedis::with(['pasien', 'dokter'])
            ->when($search, function($query, $search) {
                return $query->whereHas('pasien', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
                });
            })
            ->when($tanggal, function($query, $tanggal) {
                return $query->whereDate('tanggal_periksa', $tanggal);
            })
            ->latest('tanggal_periksa')
            ->paginate(15);

        return view('admin.rekam-medis.index', compact('rekamMedis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $pasienId = $request->get('pasien_id');
        $pasiens = Pasien::orderBy('nama')->get();
        $dokters = Dokter::with('poli')->orderBy('nama')->get();
        
        $selectedPasien = $pasienId ? Pasien::find($pasienId) : null;
        
        return view('admin.rekam-medis.create', compact('pasiens', 'dokters', 'selectedPasien'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'tanggal_periksa' => 'required|date',
        ]);

        RekamMedis::create($validated);

        return redirect()->route(auth()->user()->role . '.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(RekamMedis $rekamMedi)
    {
        $rekamMedi->load(['pasien', 'dokter.poli']);
        return view('admin.rekam-medis.show', compact('rekamMedi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekamMedis $rekamMedi)
    {
        $pasiens = Pasien::orderBy('nama')->get();
        $dokters = Dokter::with('poli')->orderBy('nama')->get();
        return view('admin.rekam-medis.edit', compact('rekamMedi', 'pasiens', 'dokters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekamMedis $rekamMedi)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'tanggal_periksa' => 'required|date',
        ]);

        $rekamMedi->update($validated);

        return redirect()->route(auth()->user()->role . '.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekamMedis $rekamMedi)
    {
        $rekamMedi->delete();

        return redirect()->route(auth()->user()->role . '.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil dihapus!');
    }

    /**
     * Get rekam medis by pasien
     */
    public function byPasien($pasienId)
    {
        $pasien = Pasien::findOrFail($pasienId);
        $rekamMedis = RekamMedis::with(['dokter.poli'])
            ->where('pasien_id', $pasienId)
            ->latest('tanggal_periksa')
            ->get();

        return view('admin.rekam-medis.by-pasien', compact('pasien', 'rekamMedis'));
    }

    /**
     * Print rekam medis
     */
    public function print(RekamMedis $rekamMedi)
    {
        $rekamMedi->load(['pasien', 'dokter.poli']);
        return view('admin.rekam-medis.print', compact('rekamMedi'));
    }

    /**
     * Laporan rekam medis berdasarkan periode
     */
    public function laporan(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());
        
        $rekamMedis = RekamMedis::with(['pasien', 'dokter'])
            ->whereBetween('tanggal_periksa', [$startDate, $endDate])
            ->latest('tanggal_periksa')
            ->get();

        return view('admin.rekam-medis.laporan', compact('rekamMedis', 'startDate', 'endDate'));
    }
}
