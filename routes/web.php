<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;

// Surat Masuk
Route::get('/surat-masuk/create', [SuratMasukController::class, 'create'])->name('suratmasuk.create');
Route::post('/surat-masuk/create', [SuratMasukController::class, 'store'])->name('suratmasuk.store');

Route::get('/suratmasuk', [SuratMasukController::class, 'index'])->name('suratmasuk.index');
Route::get('/suratmasuk/{id}', [SuratMasukController::class, 'show'])->name('suratmasuk.show');

Route::get('/suratmasuk/{id}/edit', [SuratMasukController::class, 'edit'])->name('suratmasuk.edit');
Route::put('/suratmasuk/{id}', [SuratMasukController::class, 'update'])->name('suratmasuk.update');

Route::delete('/suratmasuk/{id}', [SuratMasukController::class, 'destroy'])->name('suratmasuk.destroy');

// Surat Keluar
Route::get('/suratkeluar/create', [SuratKeluarController::class, 'create'])->name('suratkeluar.create');
Route::post('/suratkeluar', [SuratKeluarController::class, 'store'])->name('suratkeluar.store');

Route::get('/suratkeluar', [SuratKeluarController::class, 'index'])->name('suratkeluar.index');
Route::get('/suratkeluar/{id}', [SuratKeluarController::class, 'show'])->name('suratkeluar.show');

Route::get('/suratkeluar/{id}/edit', [SuratKeluarController::class, 'edit'])->name('suratkeluar.edit');
Route::put('/suratkeluar/{id}', [SuratKeluarController::class, 'update'])->name('suratkeluar.update');

Route::delete('/suratkeluar/{id}', [SuratKeluarController::class, 'destroy'])->name('suratkeluar.destroy');

// laporan
Route::get('/laporan/surat-masuk', [LaporanController::class, 'exportSuratMasuk'])->name('laporan.suratmasuk');
Route::get('/laporan/surat-keluar', [LaporanController::class, 'exportSuratKeluar'])->name('laporan.suratkeluar');

Route::get('/redirect', [UserController::class, 'redirectAfterLogin'])->name('user.redirect');

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/landing', function () {
    return view('landing');
})->name('landing');

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

    // --- Statistik ringkas ---
    $masukHariIni    = SuratMasuk::whereDate('tanggal_surat', today())->count();
    $keluarHariIni   = SuratKeluar::whereDate('tanggal_surat', today())->count();
    $masukBulanIni   = SuratMasuk::whereYear('tanggal_surat', now()->year)->whereMonth('tanggal_surat', now()->month)->count();
    $keluarBulanIni  = SuratKeluar::whereYear('tanggal_surat', now()->year)->whereMonth('tanggal_surat', now()->month)->count();
    $masukTahunIni   = SuratMasuk::whereYear('tanggal_surat', now()->year)->count();
    $keluarTahunIni  = SuratKeluar::whereYear('tanggal_surat', now()->year)->count();

    return view('halamanutama', compact(
        'suratMasukCount', 'suratKeluarCount',
        'suratMasukTerbaru', 'suratKeluarTerbaru',
        'chartLabels', 'chartMasuk', 'chartKeluar',
        'masukHariIni', 'keluarHariIni',
        'masukBulanIni', 'keluarBulanIni',
        'masukTahunIni', 'keluarTahunIni'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/halamanutama', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('halamanutama');

Route::get('/inputsuratmasuk', function () {
    return view('inputsuratmasuk');
})->name('inputsuratmasuk');

Route::get('/inputsuratkeluar', function () {
    return view('inputsuratkeluar');
})->name('inputsuratkeluar');

Route::get('/tampilsurat', function () {
    return view('tampilsurat');
})->name('tampilsurat');

Route::get('/tablesuratmasuk', function () {
    return view('tablesuratmasuk');
})->name('tablesuratmasuk');

Route::get('/tablesuratkeluar', function () {
    return view('tablesuratkeluar');
})->name('tablesuratkeluar');

Route::get('/laporan', function () {
    return view('laporan');
})->name('laporan.index');


require __DIR__.'/auth.php';
