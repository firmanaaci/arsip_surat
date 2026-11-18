<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\RecycleBinController;

use App\Models\Disposisi;
use App\Helpers\KlasifikasiSuratHelper;

// Public Routes
Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/landing', function () {
    return view('landing');
})->name('landing');

Route::get('/redirect', [UserController::class, 'redirectAfterLogin'])->name('user.redirect');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $suratMasukCount = SuratMasuk::count();
        $suratKeluarCount = SuratKeluar::count();
        $suratMasukTerbaru = SuratMasuk::latest()->take(5)->get();
        $suratKeluarTerbaru = SuratKeluar::latest('tanggal_surat')->take(5)->get();

        // --- Data grafik 12 bulan terakhir ---
        $months = collect(range(11, 0))->map(function ($i) {
            return now()->subMonths($i);
        });

        $chartLabels = $months->map(fn($m) => $m->translatedFormat('M Y') ?? $m->format('M Y'))->toArray();

        $chartMasuk = $months->map(function ($m) {
            return SuratMasuk::whereYear('tanggal_surat', $m->year)
                ->whereMonth('tanggal_surat', $m->month)
                ->count();
        })->toArray();

        $chartKeluar = $months->map(function ($m) {
            return SuratKeluar::whereYear('tanggal_surat', $m->year)
                ->whereMonth('tanggal_surat', $m->month)
                ->count();
        })->toArray();

        // --- Statistik Ringkas Waktu ---
        $masukHariIni    = SuratMasuk::whereDate('tanggal_surat', today())->count();
        $keluarHariIni   = SuratKeluar::whereDate('tanggal_surat', today())->count();
        $masukBulanIni   = SuratMasuk::whereYear('tanggal_surat', now()->year)->whereMonth('tanggal_surat', now()->month)->count();
        $keluarBulanIni  = SuratKeluar::whereYear('tanggal_surat', now()->year)->whereMonth('tanggal_surat', now()->month)->count();
        $masukTahunIni   = SuratMasuk::whereYear('tanggal_surat', now()->year)->count();
        $keluarTahunIni  = SuratKeluar::whereYear('tanggal_surat', now()->year)->count();

        // --- Metrik Disposisi Alur Kerja ---
        $disposisiTotal    = Disposisi::count();
        $disposisiMenunggu = Disposisi::where('status', 'menunggu')->count();
        $disposisiProses   = Disposisi::where('status', 'proses')->count();
        $disposisiSelesai  = Disposisi::where('status', 'selesai')->count();
        $disposisiPerluTindakLanjut = Disposisi::with('suratMasuk')
            ->whereIn('status', ['menunggu', 'proses'])
            ->latest()
            ->take(5)
            ->get();

        // --- Rasio Digitalisasi & Berkas ---
        $masukWithFile  = SuratMasuk::whereNotNull('file')->where('file', '!=', '')->count();
        $keluarWithFile = SuratKeluar::whereNotNull('file_path')->where('file_path', '!=', '')->count();
        $totalWithFile  = $masukWithFile + $keluarWithFile;
        $totalSurat     = $suratMasukCount + $suratKeluarCount;
        $digitalRatio   = $totalSurat > 0 ? round(($totalWithFile / $totalSurat) * 100) : 0;

        // --- Klasifikasi Surat Populer ---
        $klasifikasiStats = SuratKeluar::whereNotNull('kode_klasifikasi')
            ->select('kode_klasifikasi', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('kode_klasifikasi')
            ->orderByDesc('total')
            ->take(4)
            ->get();

        return view('halamanutama', compact(
            'suratMasukCount', 'suratKeluarCount',
            'suratMasukTerbaru', 'suratKeluarTerbaru',
            'chartLabels', 'chartMasuk', 'chartKeluar',
            'masukHariIni', 'keluarHariIni',
            'masukBulanIni', 'keluarBulanIni',
            'masukTahunIni', 'keluarTahunIni',
            'disposisiTotal', 'disposisiMenunggu', 'disposisiProses', 'disposisiSelesai',
            'disposisiPerluTindakLanjut',
            'masukWithFile', 'keluarWithFile', 'totalWithFile', 'totalSurat', 'digitalRatio',
            'klasifikasiStats'
        ));
    })->name('dashboard');

    Route::get('/halamanutama', function () {
        return redirect()->route('dashboard');
    })->name('halamanutama');

    // Surat Masuk
    Route::get('/surat-masuk/create', [SuratMasukController::class, 'create'])->name('suratmasuk.create');
    Route::post('/surat-masuk/create', [SuratMasukController::class, 'store'])->name('suratmasuk.store');
    Route::get('/inputsuratmasuk', function () {
        return view('inputsuratmasuk');
    })->name('inputsuratmasuk');

    Route::get('/suratmasuk', [SuratMasukController::class, 'index'])->name('suratmasuk.index');
    Route::get('/suratmasuk/{id}', [SuratMasukController::class, 'show'])->name('suratmasuk.show');
    Route::get('/suratmasuk/{id}/edit', [SuratMasukController::class, 'edit'])->name('suratmasuk.edit');
    Route::put('/suratmasuk/{id}', [SuratMasukController::class, 'update'])->name('suratmasuk.update');
    Route::delete('/suratmasuk/{id}', [SuratMasukController::class, 'destroy'])->name('suratmasuk.destroy');

    // Disposisi Surat Masuk
    Route::post('/suratmasuk/{id}/disposisi', [DisposisiController::class, 'store'])->name('disposisi.store');
    Route::patch('/disposisi/{id}/status', [DisposisiController::class, 'updateStatus'])->name('disposisi.updateStatus');
    Route::delete('/disposisi/{id}', [DisposisiController::class, 'destroy'])->name('disposisi.destroy');
    Route::get('/suratmasuk/{id}/disposisi/cetak', [DisposisiController::class, 'cetak'])->name('disposisi.cetak');

    // Surat Keluar
    Route::get('/suratkeluar/create', [SuratKeluarController::class, 'create'])->name('suratkeluar.create');
    Route::post('/suratkeluar', [SuratKeluarController::class, 'store'])->name('suratkeluar.store');
    Route::get('/api/generator-nomor-surat', [SuratKeluarController::class, 'generateNomor'])->name('suratkeluar.generateNomor');
    Route::get('/inputsuratkeluar', function () {
        return view('inputsuratkeluar');
    })->name('inputsuratkeluar');

    Route::get('/suratkeluar', [SuratKeluarController::class, 'index'])->name('suratkeluar.index');
    Route::get('/suratkeluar/{id}', [SuratKeluarController::class, 'show'])->name('suratkeluar.show');
    Route::get('/suratkeluar/{id}/edit', [SuratKeluarController::class, 'edit'])->name('suratkeluar.edit');
    Route::put('/suratkeluar/{id}', [SuratKeluarController::class, 'update'])->name('suratkeluar.update');
    Route::delete('/suratkeluar/{id}', [SuratKeluarController::class, 'destroy'])->name('suratkeluar.destroy');

    // Laporan
    Route::get('/laporan', function () {
        return view('laporan');
    })->name('laporan.index');
    Route::get('/laporan/surat-masuk', [LaporanController::class, 'exportSuratMasuk'])->name('laporan.suratmasuk');
    Route::get('/laporan/surat-keluar', [LaporanController::class, 'exportSuratKeluar'])->name('laporan.suratkeluar');

    // Manajemen Pengguna (Khusus Admin / Arsiparis)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');
        Route::post('/pengguna', [UserController::class, 'store'])->name('pengguna.store');
        Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('pengguna.update');
        Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('pengguna.destroy');

        // Tempat Sampah (Recycle Bin - Khusus Admin)
        Route::get('/recycle-bin', [RecycleBinController::class, 'index'])->name('recyclebin.index');
        Route::post('/recycle-bin/restore/{type}/{id}', [RecycleBinController::class, 'restore'])->name('recyclebin.restore');
        Route::delete('/recycle-bin/force-delete/{type}/{id}', [RecycleBinController::class, 'forceDelete'])->name('recyclebin.forceDelete');
        Route::post('/recycle-bin/empty/{type?}', [RecycleBinController::class, 'emptyTrash'])->name('recyclebin.empty');
    });

    // Audit Trail / Log Aktivitas (Admin & Pimpinan)
    Route::middleware(['role:admin,pimpinan'])->group(function () {
        Route::get('/audit-trail', [AuditTrailController::class, 'index'])->name('audit.index');
    });

    // Settings (Livewire/Volt)
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
