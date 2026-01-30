<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Resep;
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
        $obats = Obat::where('stok', '>', 0)->orderBy('nama_obat')->get();
        
        return view('admin.rekam-medis.create', compact('pasiens', 'dokters', 'selectedPasien', 'obats'));
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
            'resep' => 'nullable|array',
            'resep.*.obat_id' => 'required|exists:obats,id',
            'resep.*.jumlah' => 'required|integer|min:1',
            'resep.*.aturan_pakai' => 'required|string',
        ]);

        $rekamMedis = RekamMedis::create([
            'pasien_id' => $validated['pasien_id'],
            'dokter_id' => $validated['dokter_id'],
            'keluhan' => $validated['keluhan'],
            'diagnosa' => $validated['diagnosa'],
            'tindakan' => $validated['tindakan'],
            'tanggal_periksa' => $validated['tanggal_periksa'],
        ]);

        if (isset($validated['resep'])) {
            foreach ($validated['resep'] as $item) {
                Resep::create([
                    'rekam_medis_id' => $rekamMedis->id,
                    'obat_id' => $item['obat_id'],
                    'jumlah' => $item['jumlah'],
                    'aturan_pakai' => $item['aturan_pakai'],
                ]);
                
                // Kurangi stok
                $obat = Obat::find($item['obat_id']);
                $obat->decrement('stok', $item['jumlah']);
            }
        }

        return redirect()->route(auth()->user()->role . '.rekam-medis.index')
            ->with('success', 'Rekam medis dan resep berhasil disimpan!');
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
        $obats = Obat::orderBy('nama_obat')->get();
        $rekamMedi->load('reseps.obat');

        return view('admin.rekam-medis.edit', compact('rekamMedi', 'pasiens', 'dokters', 'obats'));
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
            'resep' => 'nullable|array',
            'resep.*.obat_id' => 'required|exists:obats,id',
            'resep.*.jumlah' => 'required|integer|min:1',
            'resep.*.aturan_pakai' => 'required|string',
        ]);

        // 1. Kembalikan stok lama sebelum diupdate
        foreach ($rekamMedi->reseps as $resepLama) {
            $obat = Obat::find($resepLama->obat_id);
            if ($obat) {
                $obat->increment('stok', $resepLama->jumlah);
            }
        }

        // 2. Hapus resep lama
        $rekamMedi->reseps()->delete();

        // 3. Update data rekam medis
        $rekamMedi->update([
            'pasien_id' => $validated['pasien_id'],
            'dokter_id' => $validated['dokter_id'],
            'keluhan' => $validated['keluhan'],
            'diagnosa' => $validated['diagnosa'],
            'tindakan' => $validated['tindakan'],
            'tanggal_periksa' => $validated['tanggal_periksa'],
        ]);

        // 4. Tambahkan resep baru dan kurangi stok
        if (isset($validated['resep'])) {
            foreach ($validated['resep'] as $item) {
                Resep::create([
                    'rekam_medis_id' => $rekamMedi->id,
                    'obat_id' => $item['obat_id'],
                    'jumlah' => $item['jumlah'],
                    'aturan_pakai' => $item['aturan_pakai'],
                ]);
                
                $obat = Obat::find($item['obat_id']);
                if ($obat) {
                    $obat->decrement('stok', $item['jumlah']);
                }
            }
        }

        return redirect()->route(auth()->user()->role . '.rekam-medis.index')
            ->with('success', 'Rekam medis dan resep berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekamMedis $rekamMedi)
    {
        // Kembalikan stok obat sebelum dihapus
        foreach ($rekamMedi->reseps as $resep) {
            $obat = Obat::find($resep->obat_id);
            if ($obat) {
                $obat->increment('stok', $resep->jumlah);
            }
        }

        $rekamMedi->delete();

        return redirect()->route(auth()->user()->role . '.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil dihapus dan stok dikembalikan!');
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
