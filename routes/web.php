<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    
    // Admin Dashboard & Management
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('poli', PoliController::class);
        Route::resource('dokter', DokterController::class);
        Route::resource('pasien', PasienController::class);
        Route::resource('pendaftaran', PendaftaranController::class);
        Route::resource('rekam-medis', RekamMedisController::class);
    });

    // Petugas Dashboard
    Route::middleware(['role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'petugas'])->name('dashboard');
        Route::resource('pasien', PasienController::class);
        Route::resource('pendaftaran', PendaftaranController::class);
    });

    // Dokter Dashboard
    Route::middleware(['role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dokter'])->name('dashboard');
        Route::resource('rekam-medis', RekamMedisController::class);
    });

    // Pasien Dashboard
    Route::middleware(['role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'pasien'])->name('dashboard');
    });

    // Shared / AJAX Routes (Accessible by all roles depending on their middleware)
    Route::get('dashboard/statistics', [DashboardController::class, 'getStatistics'])->name('dashboard.statistics');
    Route::get('dokter/by-poli/{poliId}', [DokterController::class, 'getByPoli'])->name('dokter.by-poli');
    Route::get('pasien/search/nik', [PasienController::class, 'searchByNik'])->name('pasien.search-nik');
    Route::post('pendaftaran/{pendaftaran}/update-status', [PendaftaranController::class, 'updateStatus'])->name('pendaftaran.update-status');
    Route::get('pendaftaran-today', [PendaftaranController::class, 'today'])->name('pendaftaran.today');
    Route::get('antrian', [PendaftaranController::class, 'antrian'])->name('pendaftaran.antrian');
    Route::get('rekam-medis/pasien/{pasienId}', [RekamMedisController::class, 'byPasien'])->name('rekam-medis.by-pasien');
    Route::get('rekam-medis/{rekamMedi}/print', [RekamMedisController::class, 'print'])->name('rekam-medis.print');
    Route::get('rekam-medis-laporan', [RekamMedisController::class, 'laporan'])->name('rekam-medis.laporan');
});
