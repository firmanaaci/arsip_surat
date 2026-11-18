@extends('components.layouts.app')

@section('content')

{{-- ========================================================= --}}
{{-- 1. HERO BANNER & QUICK ACTIONS                            --}}
{{-- ========================================================= --}}
<div class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-linear-to-br from-slate-50 via-white to-emerald-50/40 p-6 sm:p-8 shadow-sm mb-6">
    <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-emerald-200/30 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-24 -left-16 h-56 w-56 rounded-full bg-cyan-200/30 blur-3xl"></div>
    
    <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50/80 px-3 py-1 text-xs font-bold text-emerald-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Kementerian Agama Kota Surakarta
                </span>
                <span class="text-xs text-slate-400 font-medium hidden sm:inline">&bull;</span>
                <span class="text-xs text-slate-500 font-medium hidden sm:inline">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                Dashboard Pusat Kendali Arsip
            </h1>
            <p class="mt-1 max-w-2xl text-xs sm:text-sm text-slate-500">
                Pantau lalu lintas surat masuk, surat keluar, status disposisi, dan integritas dokumen digital.
            </p>
        </div>

        {{-- Quick Action Buttons --}}
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('suratmasuk.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-white rounded-xl shadow-md transition-all hover:-translate-y-0.5"
               style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 14px rgba(16,185,129,0.35);">
                <span class="material-icons" style="font-size:16px!important;">move_to_inbox</span>
                + Catat Surat Masuk
            </a>
            <a href="{{ route('suratkeluar.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-white rounded-xl shadow-md transition-all hover:-translate-y-0.5"
               style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 4px 14px rgba(245,158,11,0.35);">
                <span class="material-icons" style="font-size:16px!important;">outbox</span>
                + Buat Surat Keluar
            </a>
        </div>
    </div>
</div>

{{-- ========================================================= --}}
{{-- 2. METRIC KPI CARDS                                       --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Card 1: Total Surat Masuk --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                <span class="material-icons text-white" style="font-size:19px!important;">move_to_inbox</span>
            </div>
            <span class="text-[11px] text-blue-700 font-bold bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-100">
                Hari ini: +{{ $masukHariIni }}
            </span>
        </div>
        <p class="text-2xl font-extrabold text-slate-800">{{ number_format($suratMasukCount) }}</p>
        <p class="text-xs font-semibold text-slate-500 mt-1">Total Surat Masuk</p>
        <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
            <span>Bulan ini: <strong class="text-slate-700">{{ $masukBulanIni }}</strong></span>
            <span>Tahun ini: <strong class="text-slate-700">{{ $masukTahunIni }}</strong></span>
        </div>
    </div>

    {{-- Card 2: Total Surat Keluar --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                <span class="material-icons text-white" style="font-size:19px!important;">outbox</span>
            </div>
            <span class="text-[11px] text-amber-700 font-bold bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-100">
                Hari ini: +{{ $keluarHariIni }}
            </span>
        </div>
        <p class="text-2xl font-extrabold text-slate-800">{{ number_format($suratKeluarCount) }}</p>
        <p class="text-xs font-semibold text-slate-500 mt-1">Total Surat Keluar</p>
        <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
            <span>Bulan ini: <strong class="text-slate-700">{{ $keluarBulanIni }}</strong></span>
            <span>Tahun ini: <strong class="text-slate-700">{{ $keluarTahunIni }}</strong></span>
        </div>
    </div>

    {{-- Card 3: Status Alur Disposisi --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm" style="background:linear-gradient(135deg,#06b6d4,#0891b2);">
                <span class="material-icons text-white" style="font-size:19px!important;">assignment</span>
            </div>
            <span class="text-[11px] text-cyan-700 font-bold bg-cyan-50 px-2.5 py-0.5 rounded-full border border-cyan-100">
                Total: {{ $disposisiTotal }}
            </span>
        </div>
        <p class="text-2xl font-extrabold text-slate-800">{{ $disposisiMenunggu + $disposisiProses }}</p>
        <p class="text-xs font-semibold text-slate-500 mt-1">Disposisi Aktif Berjalan</p>
        <div class="mt-2 pt-2 border-t border-slate-100 grid grid-cols-3 gap-1 text-[10px] text-center font-bold">
            <div class="bg-amber-50 text-amber-700 py-1 rounded border border-amber-100" title="Menunggu Tindak Lanjut">
                {{ $disposisiMenunggu }} Menunggu
            </div>
            <div class="bg-blue-50 text-blue-700 py-1 rounded border border-blue-100" title="Sedang Diproses">
                {{ $disposisiProses }} Proses
            </div>
            <div class="bg-emerald-50 text-emerald-700 py-1 rounded border border-emerald-100" title="Selesai Ditindaklanjuti">
                {{ $disposisiSelesai }} Selesai
            </div>
        </div>
    </div>

    {{-- Card 4: Rasio Digitalisasi Arsip --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm" style="background:linear-gradient(135deg,#10b981,#059669);">
                <span class="material-icons text-white" style="font-size:19px!important;">cloud_done</span>
            </div>
            <span class="text-[11px] text-emerald-700 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-100">
                {{ $totalWithFile }} Terunggah
            </span>
        </div>
        <div class="flex items-baseline gap-2">
            <p class="text-2xl font-extrabold text-slate-800">{{ $digitalRatio }}%</p>
            <span class="text-xs font-semibold text-emerald-600">Dokumen Berkas</span>
        </div>
        <p class="text-xs font-semibold text-slate-500 mt-1">Rasio Berkas Digital</p>
        <div class="w-full bg-slate-100 h-2 rounded-full mt-2.5 overflow-hidden">
            <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500" :style="'width: {{ (int)$digitalRatio }}%'"></div>
        </div>
    </div>

</div>

{{-- ========================================================= --}}
{{-- 3. DISPOSISI & PERLU TINDAK LANJUT TRACKER                 --}}
{{-- ========================================================= --}}
@if($disposisiPerluTindakLanjut->count() > 0)
<div class="bg-white rounded-2xl border border-amber-200/80 shadow-sm mb-6 overflow-hidden">
    <div class="px-6 py-4 border-b border-amber-100 flex items-center justify-between"
         style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-sm">
                <span class="material-icons" style="font-size:16px!important;">assignment_late</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Perlu Tindak Lanjut Segera (Disposisi Aktif)</h3>
                <p class="text-[10px] text-slate-500">Instruksi disposisi pimpinan yang sedang berjalan dan membutuhkan respon seksi terkait</p>
            </div>
        </div>
        <span class="text-xs font-bold text-amber-800 bg-amber-200/70 px-3 py-1 rounded-full border border-amber-300">
            {{ $disposisiPerluTindakLanjut->count() }} Instruksi Berjalan
        </span>
    </div>

    <div class="divide-y divide-slate-100">
        @foreach($disposisiPerluTindakLanjut as $disp)
            @php
                $surat = $disp->suratMasuk;
            @endphp
            <div class="p-4 sm:px-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/80 transition-colors">
                <div class="flex items-start gap-3 min-w-0">
                    <div class="w-2.5 h-2.5 rounded-full {{ $disp->status === 'menunggu' ? 'bg-amber-400' : 'bg-blue-400' }} mt-1.5 flex-shrink-0 animate-pulse"></div>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="text-xs font-bold text-slate-800">
                                {{ $surat ? $surat->nomor_surat : 'Surat Masuk #' . $disp->surat_masuk_id }}
                            </span>
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 border border-slate-200">
                                Kepada: {{ $disp->tujuan_seksi }}
                            </span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase {{ $disp->status === 'menunggu' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                                {{ $disp->status }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 truncate max-w-xl">
                            <strong class="text-slate-700">Instruksi:</strong> {{ $disp->petunjuk_disposisi }}
                            @if($disp->catatan_disposisi)
                                &bull; <span class="italic text-slate-500">"{{ $disp->catatan_disposisi }}"</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0 self-end sm:self-center">
                    <span class="text-[11px] text-slate-400 font-medium">
                        {{ $disp->tanggal_disposisi ? \Carbon\Carbon::parse($disp->tanggal_disposisi)->format('d/m/Y') : '' }}
                    </span>
                    @if($surat)
                    <a href="{{ route('suratmasuk.show', $surat->id) }}"
                       class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-100 hover:text-blue-600 transition-all shadow-sm">
                        <span class="material-icons" style="font-size:14px!important;">visibility</span>
                        Tinjau & Respon
                    </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

{{-- ========================================================= --}}
{{-- 4. CHART & KLASIFIKASI SECTION (2 Columns)                --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Col 1 & 2: Line Chart --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                    <span class="material-icons text-slate-400" style="font-size:17px!important;">insights</span>
                    Tren Volume Surat 12 Bulan Terakhir
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Perbandingan arus surat masuk vs surat keluar per bulan</p>
            </div>
            <div class="flex items-center gap-3 text-xs font-semibold">
                <span class="flex items-center gap-1.5 text-blue-700">
                    <span class="w-3 h-3 rounded-full inline-block bg-blue-500"></span>
                    Surat Masuk
                </span>
                <span class="flex items-center gap-1.5 text-amber-700">
                    <span class="w-3 h-3 rounded-full inline-block bg-amber-500"></span>
                    Surat Keluar
                </span>
            </div>
        </div>

        <div class="p-4 sm:p-6 flex-1 min-h-[260px] relative" id="chart-container">
            <canvas id="suratChart"></canvas>
        </div>
    </div>

    {{-- Col 3: KMA Classification Breakdown --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                <span class="material-icons text-slate-400" style="font-size:17px!important;">pie_chart</span>
                Distribusi Klasifikasi KMA
            </h2>
            <p class="text-xs text-slate-400 mt-0.5">Kode tata naskah dinas Kemenag terbanyak</p>
        </div>

        <div class="p-6 flex-1 flex flex-col justify-between">
            @php
                $kmaMap = [
                    'KP' => ['nama' => 'Kepegawaian', 'color' => 'bg-blue-500', 'text' => 'text-blue-700', 'bg' => 'bg-blue-50'],
                    'PP' => ['nama' => 'Pendidikan Islam', 'color' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'bg' => 'bg-emerald-50'],
                    'BA' => ['nama' => 'Bimbingan Masyarakat', 'color' => 'bg-purple-500', 'text' => 'text-purple-700', 'bg' => 'bg-purple-50'],
                    'HJ' => ['nama' => 'Haji & Umrah', 'color' => 'bg-amber-500', 'text' => 'text-amber-700', 'bg' => 'bg-amber-50'],
                    'KU' => ['nama' => 'Keuangan', 'color' => 'bg-rose-500', 'text' => 'text-rose-700', 'bg' => 'bg-rose-50'],
                    'HM' => ['nama' => 'Humas & Kerjasama', 'color' => 'bg-cyan-500', 'text' => 'text-cyan-700', 'bg' => 'bg-cyan-50'],
                ];
            @endphp

            @if($klasifikasiStats->count() > 0)
                <div class="space-y-4">
                    @foreach($klasifikasiStats as $stat)
                        @php
                            $info = $kmaMap[$stat->kode_klasifikasi] ?? ['nama' => 'Lainnya', 'color' => 'bg-slate-500', 'text' => 'text-slate-700', 'bg' => 'bg-slate-50'];
                            $percent = $suratKeluarCount > 0 ? round(($stat->total / $suratKeluarCount) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-bold text-slate-700 flex items-center gap-1.5">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-mono {{ $info['bg'] }} {{ $info['text'] }} font-extrabold border">
                                        {{ $stat->kode_klasifikasi }}
                                    </span>
                                    {{ $info['nama'] }}
                                </span>
                                <span class="font-semibold text-slate-500">{{ $stat->total }} surat ({{ $percent }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="{{ $info['color'] }} h-2 rounded-full transition-all duration-500" :style="'width: {{ (int)$percent }}%'"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-slate-400">
                    <span class="material-icons text-slate-300" style="font-size:36px!important;">folder_open</span>
                    <p class="text-xs mt-1">Belum ada data kode klasifikasi</p>
                </div>
            @endif

            <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('suratkeluar.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700 inline-flex items-center gap-1">
                    Lihat Seluruh Arsip Terklasifikasi
                    <span class="material-icons" style="font-size:13px!important;">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>

</div>

{{-- ========================================================= --}}
{{-- 5. RECENT LETTERS FEED (2 Columns)                        --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Surat Masuk Terbaru --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <span class="material-icons" style="font-size:15px!important;">move_to_inbox</span>
                </div>
                <h3 class="text-sm font-bold text-slate-800">5 Surat Masuk Terbaru</h3>
            </div>
            <a href="{{ route('suratmasuk.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-0.5">
                Lihat Semua
                <span class="material-icons" style="font-size:13px!important;">chevron_right</span>
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($suratMasukTerbaru as $sm)
                <a href="{{ route('suratmasuk.show', $sm->id) }}" class="p-4 flex items-center justify-between hover:bg-slate-50/80 transition-colors group block">
                    <div class="min-w-0 pr-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-xs text-slate-800 group-hover:text-blue-600 transition-colors truncate">
                                {{ $sm->nomor_surat }}
                            </span>
                            @if($sm->file)
                                <span class="material-icons text-emerald-500" style="font-size:13px!important;" title="Lampiran digital tersedia">attach_file</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 truncate">
                            <span class="font-semibold text-slate-700">Dari:</span> {{ $sm->pengirim ?? '-' }}
                        </p>
                        @if($sm->tujuan_surat)
                        <p class="text-[11px] text-slate-500 truncate mt-0.5">
                            <span class="font-semibold text-slate-700">Penerima:</span> {{ $sm->tujuan_surat }}
                        </p>
                        @endif
                    </div>
                    <div class="text-right flex-shrink-0">
                        <span class="text-[11px] text-slate-400 font-medium block">
                            {{ $sm->tanggal_surat ? \Carbon\Carbon::parse($sm->tanggal_surat)->format('d/m/Y') : '-' }}
                        </span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 border mt-1 inline-block">
                            {{ $sm->sifat_surat ?? 'Biasa' }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="text-center py-8 text-slate-400 text-xs">Belum ada data surat masuk</div>
            @endforelse
        </div>
    </div>

    {{-- Surat Keluar Terbaru --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                    <span class="material-icons" style="font-size:15px!important;">outbox</span>
                </div>
                <h3 class="text-sm font-bold text-slate-800">5 Surat Keluar Terbaru</h3>
            </div>
            <a href="{{ route('suratkeluar.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700 flex items-center gap-0.5">
                Lihat Semua
                <span class="material-icons" style="font-size:13px!important;">chevron_right</span>
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($suratKeluarTerbaru as $sk)
                <a href="{{ route('suratkeluar.show', $sk->id) }}" class="p-4 flex items-center justify-between hover:bg-slate-50/80 transition-colors group block">
                    <div class="min-w-0 pr-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-xs text-slate-800 group-hover:text-amber-600 transition-colors truncate">
                                {{ $sk->nomor_surat }}
                            </span>
                            @if($sk->kode_klasifikasi)
                                <span class="text-[9px] font-mono font-bold px-1.5 py-0.2 rounded bg-amber-100 text-amber-800 border border-amber-200">
                                    {{ $sk->kode_klasifikasi }}
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 truncate">
                            <span class="font-semibold text-slate-700">Tujuan:</span> {{ $sk->tujuan_surat }}
                        </p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <span class="text-[11px] text-slate-400 font-medium block">
                            {{ $sk->tanggal_surat ? \Carbon\Carbon::parse($sk->tanggal_surat)->format('d/m/Y') : '-' }}
                        </span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 border mt-1 inline-block">
                            {{ $sk->sifat_surat ?? 'Biasa' }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="text-center py-8 text-slate-400 text-xs">Belum ada data surat keluar</div>
            @endforelse
        </div>
    </div>

</div>

{{-- ========================================================= --}}
{{-- 6. CHART.JS CONFIGURATION                                 --}}
{{-- ========================================================= --}}
<script type="application/json" id="chart-data">
{
    "labels": {!! json_encode($chartLabels) !!},
    "masuk":  {!! json_encode($chartMasuk) !!},
    "keluar": {!! json_encode($chartKeluar) !!}
}
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    const dataEl = document.getElementById('chart-data');
    const canvas = document.getElementById('suratChart');
    if (!dataEl || !canvas || typeof Chart === 'undefined') return;

    const _data = JSON.parse(dataEl.textContent);
    const labels = _data.labels;
    const masuk  = _data.masuk;
    const keluar = _data.keluar;

    const isMobile = window.matchMedia('(max-width: 639px)').matches;
    const chartContainer = document.getElementById('chart-container');
    if (!isMobile) chartContainer.style.height = '280px';

    const ctx = document.getElementById('suratChart').getContext('2d');

    const gradMasuk = ctx.createLinearGradient(0, 0, 0, isMobile ? 180 : 260);
    gradMasuk.addColorStop(0, 'rgba(59,130,246,0.22)');
    gradMasuk.addColorStop(1, 'rgba(59,130,246,0.01)');

    const gradKeluar = ctx.createLinearGradient(0, 0, 0, isMobile ? 180 : 260);
    gradKeluar.addColorStop(0, 'rgba(245,158,11,0.22)');
    gradKeluar.addColorStop(1, 'rgba(245,158,11,0.01)');

    const existingChart = Chart.getChart(canvas);
    if (existingChart) existingChart.destroy();

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
                    pointRadius: isMobile ? 2.5 : 4.5,
                    pointHoverRadius: isMobile ? 4.5 : 6.5,
                    tension: 0.35,
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
                    pointRadius: isMobile ? 2.5 : 4.5,
                    pointHoverRadius: isMobile ? 4.5 : 6.5,
                    tension: 0.35,
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
                        color: '#f8fafc',
                        borderDash: [3, 3],
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
})();
</script>

@endsection
