@extends('components.layouts.app')

@section('content')

{{-- Page Header --}}
<div class="mb-6">
    <div class="flex items-center gap-2 mb-2">
        <a href="{{ route('halamanutama') }}" class="text-slate-400 hover:text-slate-600 text-sm flex items-center gap-1 transition-colors">
            <span class="material-icons" style="font-size:16px!important;">home</span>Dashboard
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-600 text-sm font-medium">Laporan & Export</span>
    </div>
    <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);">
            <span class="material-icons text-white" style="font-size:18px!important;">assessment</span>
        </div>
        Laporan & Export Data
    </h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Form Export Surat Masuk --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3" style="background:linear-gradient(135deg,#eff6ff,#f0fdf4);">
            <div class="w-9 h-9 rounded-xl bg-blue-500 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                <span class="material-icons" style="font-size:18px!important;">move_to_inbox</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-base">Export Laporan Surat Masuk</h2>
                <p class="text-xs text-slate-500">Pilih rentang tanggal untuk mengunduh berkas CSV</p>
            </div>
        </div>

        <form method="GET" action="{{ route('laporan.suratmasuk') }}" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Tanggal Awal</label>
                <input type="date" name="start_date"
                    class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 bg-white">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Tanggal Akhir</label>
                <input type="date" name="end_date"
                    class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 bg-white">
            </div>
            <div class="pt-2">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold text-white rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-md"
                    style="background:linear-gradient(135deg,#10b981,#059669); box-shadow:0 4px 14px rgba(16,185,129,0.35);">
                    <span class="material-icons" style="font-size:18px!important;">download</span>
                    Unduh Laporan Surat Masuk (CSV)
                </button>
            </div>
        </form>
    </div>

    {{-- Form Export Surat Keluar --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3" style="background:linear-gradient(135deg,#fffbeb,#fff7ed);">
            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                <span class="material-icons" style="font-size:18px!important;">outbox</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-base">Export Laporan Surat Keluar</h2>
                <p class="text-xs text-slate-500">Pilih rentang tanggal untuk mengunduh berkas CSV</p>
            </div>
        </div>

        <form method="GET" action="{{ route('laporan.suratkeluar') }}" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Tanggal Awal</label>
                <input type="date" name="start_date"
                    class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500/25 focus:border-amber-400 bg-white">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Tanggal Akhir</label>
                <input type="date" name="end_date"
                    class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500/25 focus:border-amber-400 bg-white">
            </div>
            <div class="pt-2">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold text-white rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-md"
                    style="background:linear-gradient(135deg,#f59e0b,#d97706); box-shadow:0 4px 14px rgba(245,158,11,0.35);">
                    <span class="material-icons" style="font-size:18px!important;">download</span>
                    Unduh Laporan Surat Keluar (CSV)
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
