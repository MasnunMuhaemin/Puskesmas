<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $tanggal = $request->get('tanggal');
        
        $pendaftarans = Pendaftaran::with(['pasien', 'poli'])
            ->when($status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->when($tanggal, function($query, $tanggal) {
                return $query->whereDate('tanggal_daftar', $tanggal);
            })
            ->latest('tanggal_daftar')
            ->paginate(15);

        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasiens = Pasien::orderBy('nama')->get();
        $polis = Poli::all();
        return view('admin.pendaftaran.create', compact('pasiens', 'polis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:menunggu,selesai,batal',
        ]);

        Pendaftaran::create($validated);

        return redirect()->route(auth()->user()->role . '.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['pasien', 'poli']);
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendaftaran $pendaftaran)
    {
        $pasiens = Pasien::orderBy('nama')->get();
        $polis = Poli::all();
        return view('admin.pendaftaran.edit', compact('pendaftaran', 'pasiens', 'polis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:menunggu,selesai,batal',
        ]);

        $pendaftaran->update($validated);

        return redirect()->route(auth()->user()->role . '.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        $pendaftaran->delete();

        return redirect()->route(auth()->user()->role . '.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dihapus!');
    }

    /**
     * Update status pendaftaran
     */
    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,selesai,batal',
        ]);

        $pendaftaran->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pendaftaran berhasil diupdate!');
    }

    /**
     * Get pendaftaran hari ini (for dashboard widget)
     */
    public function today()
    {
        $pendaftarans = Pendaftaran::with(['pasien', 'poli'])
            ->whereDate('tanggal_daftar', today())
            ->latest()
            ->get();

        return view('admin.pendaftaran.today', compact('pendaftarans'));
    }

    /**
     * Antrian pendaftaran (queue)
     */
    public function antrian()
    {
        $antrian = Pendaftaran::with(['pasien', 'poli'])
            ->whereDate('tanggal_daftar', today())
            ->where('status', 'menunggu')
            ->orderBy('created_at')
            ->get();

        return view('admin.pendaftaran.antrian', compact('antrian'));
    }
}
