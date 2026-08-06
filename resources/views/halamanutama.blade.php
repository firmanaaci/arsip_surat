@extends('components.layouts.app')

@section('content')

{{-- ===== HERO BANNER ===== --}}
<div class="relative overflow-hidden rounded-2xl border border-slate-200/70 bg-gradient-to-br from-slate-50 via-white to-emerald-50/50 p-5 shadow-sm sm:p-8 mb-5">
    <div class="pointer-events-none absolute -right-16 -top-16 h-44 w-44 rounded-full bg-emerald-200/40 blur-2xl"></div>
    <div class="pointer-events-none absolute -bottom-24 -left-16 h-52 w-52 rounded-full bg-cyan-200/40 blur-2xl"></div>
    <div class="relative flex flex-col gap-3">
        <div>
            <p class="mb-2 inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-emerald-700">
                Arsip Surat
            </p>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-800 sm:text-4xl">Dashboard</h1>
            <p class="mt-1.5 max-w-2xl text-xs text-slate-500 sm:text-base sm:mt-2">
                Ringkasan dan statistik pengelolaan surat masuk dan surat keluar.
            </p>
        </div>
        <div class="inline-flex items-center self-start gap-2 rounded-xl border border-slate-200 bg-white/80 px-3 py-2 text-xs text-slate-500 shadow-sm backdrop-blur">
            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Sistem siap digunakan
        </div>
    </div>
</div>

{{-- ===== STATS CARDS ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-5">

    {{-- Total Surat Masuk --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                <span class="material-icons text-white" style="font-size:18px!important;">move_to_inbox</span>
            </div>
            <span class="text-xs text-emerald-600 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                Hari ini: {{ $masukHariIni }}
            </span>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $suratMasukCount }}</p>
        <p class="text-xs text-slate-500 mt-1">Total Surat Masuk</p>
        <p class="text-xs text-slate-400 mt-0.5">Bulan ini: {{ $masukBulanIni }} · Tahun ini: {{ $masukTahunIni }}</p>
    </div>

    {{-- Total Surat Keluar --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                <span class="material-icons text-white" style="font-size:18px!important;">outbox</span>
            </div>
            <span class="text-xs text-amber-600 font-semibold bg-amber-50 px-2 py-0.5 rounded-full border border-amber-100">
                Hari ini: {{ $keluarHariIni }}
            </span>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $suratKeluarCount }}</p>
        <p class="text-xs text-slate-500 mt-1">Total Surat Keluar</p>
        <p class="text-xs text-slate-400 mt-0.5">Bulan ini: {{ $keluarBulanIni }} · Tahun ini: {{ $keluarTahunIni }}</p>
    </div>

    {{-- Total Semua --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);">
                <span class="material-icons text-white" style="font-size:18px!important;">folder</span>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $suratMasukCount + $suratKeluarCount }}</p>
        <p class="text-xs text-slate-500 mt-1">Total Seluruh Arsip</p>
        <p class="text-xs text-slate-400 mt-0.5">Semua dokumen terarsip</p>
    </div>

    {{-- Bulan Ini --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#10b981,#059669);">
                <span class="material-icons text-white" style="font-size:18px!important;">calendar_month</span>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $masukBulanIni + $keluarBulanIni }}</p>
        <p class="text-xs text-slate-500 mt-1">Surat Bulan {{ now()->translatedFormat('F') }}</p>
        <p class="text-xs text-slate-400 mt-0.5">Masuk {{ $masukBulanIni }} · Keluar {{ $keluarBulanIni }}</p>
    </div>

</div>

{{-- ===== GRAFIK ===== --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6 overflow-hidden">

    {{-- Chart Header --}}
    <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="font-bold text-slate-800 text-base flex items-center gap-2">
                <span class="material-icons text-slate-400" style="font-size:18px!important;">bar_chart</span>
                Grafik Surat Masuk & Keluar
            </h2>
            <p class="text-xs text-slate-400 mt-0.5">Perbandingan volume surat per bulan dalam 12 bulan terakhir</p>
        </div>
        <div class="flex items-center gap-4 text-xs font-semibold">
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm inline-block" style="background:#3b82f6;"></span>
                Surat Masuk
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm inline-block" style="background:#f59e0b;"></span>
                Surat Keluar
            </span>
        </div>
    </div>

    {{-- Chart Canvas --}}
    <div class="p-3 sm:p-6" style="height:220px; position:relative;" id="chart-container">
        <canvas id="suratChart"></canvas>
    </div>
</div>

{{-- ===== QUICK ACCESS CARDS ===== --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:gap-5">

    {{-- Kartu Surat Masuk --}}
    <a href="{{ route('suratmasuk.index') }}" class="group relative overflow-hidden rounded-2xl border border-emerald-200 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-700 p-5 text-white shadow-lg shadow-emerald-900/20 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-900/25">
        <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-white/15 blur-xl transition duration-300 group-hover:scale-110"></div>
        <div class="relative flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-emerald-100">Surat Masuk</p>
                <h2 class="mt-2 text-2xl font-semibold">Kelola Data</h2>
                <p class="mt-2 text-sm text-emerald-100/90">Lihat, cari, dan perbarui arsip surat masuk dengan cepat.</p>
            </div>
            <svg class="h-11 w-11 text-emerald-100/80" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 3a1 1 0 011-1h14a1 1 0 011 1v2l-8 5-8-5V3z" />
                <path d="M18 8l-8 5-8-5v7a1 1 0 001 1h14a1 1 0 001-1V8z" />
            </svg>
        </div>
        <div class="relative mt-5 inline-flex items-center gap-2 text-sm font-semibold text-white/95">
            Buka halaman
            <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h9.586l-3.293-3.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L13.586 11H4a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
        </div>
    </a>

    {{-- Kartu Surat Keluar --}}
    <a href="{{ route('suratkeluar.index') }}" class="group relative overflow-hidden rounded-2xl border border-amber-200 bg-gradient-to-br from-amber-400 via-amber-500 to-orange-600 p-5 text-white shadow-lg shadow-amber-900/20 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-900/25">
        <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-white/15 blur-xl transition duration-300 group-hover:scale-110"></div>
        <div class="relative flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-amber-100">Surat Keluar</p>
                <h2 class="mt-2 text-2xl font-semibold">Kelola Data</h2>
                <p class="mt-2 text-sm text-amber-100/90">Pantau surat keluar dan pastikan distribusi dokumen tercatat rapi.</p>
            </div>
            <span class="material-icons text-amber-100/80" style="font-size:44px!important;">outbox</span>
        </div>
        <div class="relative mt-5 inline-flex items-center gap-2 text-sm font-semibold text-white/95">
            Buka halaman
            <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h9.586l-3.293-3.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L13.586 11H4a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
        </div>
    </a>
</div>

{{-- ===== CHART.JS ===== --}}
{{-- Data island: linter-safe way to pass PHP data to JS --}}
<script type="application/json" id="chart-data">
{
    "labels": {!! json_encode($chartLabels) !!},
    "masuk":  {!! json_encode($chartMasuk) !!},
    "keluar": {!! json_encode($chartKeluar) !!}
}
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const _data  = JSON.parse(document.getElementById('chart-data').textContent);
    const labels = _data.labels;
    const masuk  = _data.masuk;
    const keluar = _data.keluar;

    // Responsive chart height
    const isMobile = window.matchMedia('(max-width: 639px)').matches;
    const chartContainer = document.getElementById('chart-container');
    if (!isMobile) chartContainer.style.height = '320px';

    const ctx = document.getElementById('suratChart').getContext('2d');

    // Gradient fills
    const gradMasuk = ctx.createLinearGradient(0, 0, 0, isMobile ? 200 : 300);
    gradMasuk.addColorStop(0, 'rgba(59,130,246,0.25)');
    gradMasuk.addColorStop(1, 'rgba(59,130,246,0.02)');

    const gradKeluar = ctx.createLinearGradient(0, 0, 0, isMobile ? 200 : 300);
    gradKeluar.addColorStop(0, 'rgba(245,158,11,0.25)');
    gradKeluar.addColorStop(1, 'rgba(245,158,11,0.02)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Surat Masuk',
                    data: masuk,
                    borderColor: '#3b82f6',
                    backgroundColor: gradMasuk,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: isMobile ? 3 : 5,
                    pointHoverRadius: isMobile ? 5 : 7,
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Surat Keluar',
                    data: keluar,
                    borderColor: '#f59e0b',
                    backgroundColor: gradKeluar,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#f59e0b',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: isMobile ? 3 : 5,
                    pointHoverRadius: isMobile ? 5 : 7,
                    tension: 0.4,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#1e293b',
                    bodyColor: '#64748b',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    padding: 10,
                    callbacks: {
                        label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y} surat`,
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: isMobile ? 9 : 11 },
                        maxRotation: isMobile ? 45 : 0,
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9',
                        borderDash: [4, 4],
                    },
                    border: { display: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: isMobile ? 9 : 11 },
                        stepSize: 1,
                        precision: 0,
                    }
                }
            }
        }
    });
</script>

@endsection
