@extends('components.layouts.app')


@section('content')
    <div class="relative overflow-hidden rounded-3xl border border-slate-200/70 bg-gradient-to-br from-slate-50 via-white to-emerald-50/50 p-6 shadow-sm sm:p-8">
        <div class="pointer-events-none absolute -right-16 -top-16 h-44 w-44 rounded-full bg-emerald-200/40 blur-2xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-16 h-52 w-52 rounded-full bg-cyan-200/40 blur-2xl"></div>

        <div class="relative flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-emerald-700">
                    Arsip Surat
                </p>
                <h1 class="text-3xl font-semibold tracking-tight text-slate-800 sm:text-4xl">
                    Dashboard
                </h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-600 sm:text-base">
                    Ringkasan akses cepat untuk pengelolaan surat masuk dan surat keluar.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white/80 px-3 py-2 text-xs text-slate-500 shadow-sm backdrop-blur">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                Sistem siap digunakan
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:gap-5">
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
                <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h9.586l-3.293-3.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L13.586 11H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
        </a>

        {{-- Kartu Surat Keluar --}}
        <a href="{{ route('suratkeluar.index') }}" class="group relative overflow-hidden rounded-2xl border border-rose-200 bg-gradient-to-br from-rose-500 via-red-600 to-amber-600 p-5 text-white shadow-lg shadow-rose-900/20 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-rose-900/25">
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-white/15 blur-xl transition duration-300 group-hover:scale-110"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-rose-100">Surat Keluar</p>
                    <h2 class="mt-2 text-2xl font-semibold">Kelola Data</h2>
                    <p class="mt-2 text-sm text-rose-100/90">Pantau surat keluar dan pastikan distribusi dokumen tercatat rapi.</p>
                </div>
                <svg class="h-11 w-11 text-rose-100/80" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4h16v2H4V4zm0 5h16v2H4V9zm0 5h10v2H4v-2z" />
                </svg>
            </div>
            <div class="relative mt-5 inline-flex items-center gap-2 text-sm font-semibold text-white/95">
                Buka halaman
                <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h9.586l-3.293-3.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L13.586 11H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
        </a>
    </div>
@endsection
