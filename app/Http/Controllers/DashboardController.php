<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\Pendaftaran;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display dashboard with statistics
     */
    public function index()
    {
        // Statistik Umum
        $totalPasien = Pasien::count();
        $totalDokter = Dokter::count();
        $totalPoli = Poli::count();
        
        // Statistik Hari Ini
        $pendaftaranHariIni = Pendaftaran::whereDate('tanggal_daftar', today())->count();
        $pemeriksaanHariIni = RekamMedis::whereDate('tanggal_periksa', today())->count();
        
        // Antrian menunggu hari ini
        $antrianMenunggu = Pendaftaran::whereDate('tanggal_daftar', today())
            ->where('status', 'menunggu')
            ->count();
        
        // Statistik Bulan Ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $pendaftaranBulanIni = Pendaftaran::whereBetween('tanggal_daftar', [$startOfMonth, $endOfMonth])->count();
        $pemeriksaanBulanIni = RekamMedis::whereBetween('tanggal_periksa', [$startOfMonth, $endOfMonth])->count();
        
        // Pasien baru bulan ini
        $pasienBaruBulanIni = Pasien::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        
        // Grafik pendaftaran 7 hari terakhir
        $pendaftaran7Hari = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Pendaftaran::whereDate('tanggal_daftar', $date)->count();
            $pendaftaran7Hari[] = [
                'tanggal' => $date->format('d M'),
                'jumlah' => $count
            ];
        }
        
        // Top 5 Poli dengan pendaftaran terbanyak bulan ini
        $topPoli = Pendaftaran::with('poli')
            ->whereBetween('tanggal_daftar', [$startOfMonth, $endOfMonth])
            ->select('poli_id', \DB::raw('count(*) as total'))
            ->groupBy('poli_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Aktivitas terbaru (pendaftaran & rekam medis)
        $aktivitasTerbaru = $this->getRecentActivities();
        
        // Status pendaftaran hari ini
        $statusPendaftaran = [
            'menunggu' => Pendaftaran::whereDate('tanggal_daftar', today())->where('status', 'menunggu')->count(),
            'selesai' => Pendaftaran::whereDate('tanggal_daftar', today())->where('status', 'selesai')->count(),
            'batal' => Pendaftaran::whereDate('tanggal_daftar', today())->where('status', 'batal')->count(),
        ];
        
        return view('admin.dashboard.index', compact(
            'totalPasien',
            'totalDokter',
            'totalPoli',
            'pendaftaranHariIni',
            'pemeriksaanHariIni',
            'antrianMenunggu',
            'pendaftaranBulanIni',
            'pemeriksaanBulanIni',
            'pasienBaruBulanIni',
            'pendaftaran7Hari',
            'topPoli',
            'aktivitasTerbaru',
            'statusPendaftaran'
        ));
    }
    
    /**
     * Get recent activities
     */
    private function getRecentActivities()
    {
        $pendaftarans = Pendaftaran::with(['pasien', 'poli'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'pendaftaran',
                    'message' => "{$item->pasien->nama} mendaftar di {$item->poli->nama_poli}",
                    'time' => $item->created_at,
                    'icon' => 'calendar',
                    'color' => 'primary'
                ];
            });
        
        $rekamMedis = RekamMedis::with(['pasien', 'dokter'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'rekam_medis',
                    'message' => "{$item->pasien->nama} diperiksa oleh {$item->dokter->nama}",
                    'time' => $item->created_at,
                    'icon' => 'file-text',
                    'color' => 'success'
                ];
            });
        
        return $pendaftarans->concat($rekamMedis)
            ->sortByDesc('time')
            ->take(10)
            ->values();
    }
    
    /**
     * Petugas Dashboard
     */
    public function petugas()
    {
        $totalPasien = Pasien::count();
        $antrianHariIni = Pendaftaran::whereDate('tanggal_daftar', today())->count();
        $pasienMenunggu = Pendaftaran::whereDate('tanggal_daftar', today())->where('status', 'menunggu')->count();
        $recentPendaftaran = Pendaftaran::with(['pasien', 'poli'])->latest()->take(5)->get();

        return view('petugas.dashboard', compact('totalPasien', 'antrianHariIni', 'pasienMenunggu', 'recentPendaftaran'));
    }

    /**
     * Dokter Dashboard
     */
    public function dokter()
    {
        $totalPemeriksaan = RekamMedis::count();
        $pemeriksaanHariIni = RekamMedis::whereDate('tanggal_periksa', today())->count();
        $antrianSekarang = Pendaftaran::with(['pasien', 'poli'])
            ->whereDate('tanggal_daftar', today())
            ->where('status', 'menunggu')
            ->orderBy('created_at')
            ->get();

        return view('dokter.dashboard', compact('totalPemeriksaan', 'pemeriksaanHariIni', 'antrianSekarang'));
    }

    /**
     * Pasien Dashboard
     */
    public function pasien()
    {
        $user = auth()->user();
        $pasien = Pasien::where('nik', $user->nik)->first();
        
        $rekamMedis = collect();
        if ($pasien) {
            $rekamMedis = RekamMedis::with(['dokter.poli'])
                ->where('pasien_id', $pasien->id)
                ->latest('tanggal_periksa')
                ->get();
        }

        return view('pasien.dashboard', compact('user', 'pasien', 'rekamMedis'));
    }

    /**
     * Get statistics for specific date range (AJAX)
     */
    public function getStatistics(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $data = [
            'pendaftaran' => Pendaftaran::whereBetween('tanggal_daftar', [$startDate, $endDate])->count(),
            'pemeriksaan' => RekamMedis::whereBetween('tanggal_periksa', [$startDate, $endDate])->count(),
            'pasien_baru' => Pasien::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];
        
        return response()->json($data);
    }
}
