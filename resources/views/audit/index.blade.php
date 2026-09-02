@extends('components.layouts.app')

@section('content')

<div class="space-y-6">

    {{-- ======================================================== --}}
    {{-- 1. PAGE HEADER & BREADCRUMB                              --}}
    {{-- ======================================================== --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-slate-600 text-xs flex items-center gap-1 transition-colors">
                    <span class="material-icons" style="font-size:15px!important;">home</span>
                    Dashboard
                </a>
                <span class="text-slate-300 text-xs">/</span>
                <span class="text-slate-700 text-xs font-semibold">Tata Kelola & Keamanan</span>
                <span class="text-slate-300 text-xs">/</span>
                <span class="text-sky-600 text-xs font-bold">Audit Trail</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-800 flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-md shadow-sky-500/20"
                     style="background: linear-gradient(135deg, #0ea5e9, #0284c7);">
                    <span class="material-icons text-white" style="font-size:20px!important;">history</span>
                </div>
                Log Aktivitas & Riwayat Sistem
            </h1>
            <p class="text-xs text-slate-500 mt-1">Audit trail terperinci untuk merekam setiap interaksi data: pencatatan surat, perubahan, pengunduhan, hingga penghapusan.</p>
        </div>

        <div class="flex items-center gap-2.5 self-start md:self-auto">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Audit Logging Aktif
            </span>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- 2. METRIC STATS CARDS                                    --}}
    {{-- ======================================================== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Log --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition-all flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center flex-shrink-0">
                <span class="material-icons" style="font-size:22px!important;">receipt_long</span>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider truncate">Total Rekaman</p>
                <p class="text-xl font-extrabold text-slate-800 leading-tight">{{ number_format($stats['total']) }}</p>
            </div>
        </div>

        {{-- Log Hari Ini --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition-all flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 border border-blue-100">
                <span class="material-icons" style="font-size:22px!important;">today</span>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] text-blue-600 font-bold uppercase tracking-wider truncate">Aktivitas Hari Ini</p>
                <p class="text-xl font-extrabold text-slate-800 leading-tight">+{{ number_format($stats['today']) }}</p>
            </div>
        </div>

        {{-- Entri Baru --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition-all flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 border border-emerald-100">
                <span class="material-icons" style="font-size:22px!important;">add_circle</span>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] text-emerald-600 font-bold uppercase tracking-wider truncate">Pencatatan Baru</p>
                <p class="text-xl font-extrabold text-slate-800 leading-tight">{{ number_format($stats['creates']) }}</p>
            </div>
        </div>

        {{-- Aksi Hapus --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition-all flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0 border border-rose-100">
                <span class="material-icons" style="font-size:22px!important;">delete_sweep</span>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] text-rose-600 font-bold uppercase tracking-wider truncate">Penghapusan</p>
                <p class="text-xl font-extrabold text-slate-800 leading-tight">{{ number_format($stats['deletes']) }}</p>
            </div>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- 3. STRUCTURED FILTER & SEARCH PANEL                      --}}
    {{-- ======================================================== --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <form method="GET" action="{{ route('audit.index') }}" class="space-y-4">
            {{-- Top Row: Keyword Search + Dropdowns --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                {{-- Search Box --}}
                <div class="md:col-span-5 relative">
                    <span class="material-icons absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" style="font-size:18px!important;">search</span>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari deskripsi, nama user, atau alamat IP..."
                           class="w-full pl-10 pr-3 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                </div>

                {{-- Action Type Filter --}}
                <div class="md:col-span-4">
                    <select name="action"
                            class="w-full px-3 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 bg-white transition">
                        <option value="">Semua Jenis Aksi (Action)</option>
                        <option value="CREATE" {{ $actionFilter === 'CREATE' ? 'selected' : '' }}>🟢 CREATE (Tambah / Input Baru)</option>
                        <option value="UPDATE" {{ $actionFilter === 'UPDATE' ? 'selected' : '' }}>🔵 UPDATE (Perubahan / Edit)</option>
                        <option value="DELETE" {{ $actionFilter === 'DELETE' ? 'selected' : '' }}>🟡 DELETE (Pindah ke Sampah)</option>
                        <option value="RESTORE" {{ $actionFilter === 'RESTORE' ? 'selected' : '' }}>🟣 RESTORE (Pemulihan Data)</option>
                        <option value="FORCE_DELETE" {{ $actionFilter === 'FORCE_DELETE' ? 'selected' : '' }}>🔴 FORCE DELETE (Hapus Permanen)</option>
                        <option value="DOWNLOAD" {{ $actionFilter === 'DOWNLOAD' ? 'selected' : '' }}>🌐 DOWNLOAD / CETAK (Unduh Berkas)</option>
                        <option value="LOGIN" {{ $actionFilter === 'LOGIN' ? 'selected' : '' }}>🔑 LOGIN (Masuk Akun)</option>
                    </select>
                </div>

                {{-- User Filter --}}
                <div class="md:col-span-3">
                    <select name="user_id"
                            class="w-full px-3 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 bg-white transition">
                        <option value="">Semua Pengguna (User)</option>
                        @foreach($users as $usr)
                            <option value="{{ $usr->id }}" {{ $userFilter == $usr->id ? 'selected' : '' }}>
                                {{ $usr->name }} ({{ $usr->role_label }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Bottom Row: Date Range & Action Buttons --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-3 border-t border-slate-100">
                <div class="flex items-center gap-2 text-xs text-slate-500 flex-wrap">
                    <span class="font-semibold text-slate-600 flex items-center gap-1">
                        <span class="material-icons text-slate-400" style="font-size:16px!important;">date_range</span>
                        Rentang Waktu:
                    </span>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                           class="px-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 bg-white">
                    <span class="text-slate-400">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                           class="px-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 bg-white">
                </div>

                <div class="flex items-center gap-2 self-end sm:self-auto">
                    @if($search || $actionFilter || $userFilter || $startDate || $endDate)
                        <a href="{{ route('audit.index') }}"
                           class="px-3.5 py-2 text-xs font-semibold text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition border border-slate-200 flex items-center gap-1">
                            <span class="material-icons" style="font-size:15px!important;">clear</span>
                            Reset Filter
                        </a>
                    @endif

                    <button type="submit"
                            class="px-5 py-2 text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 rounded-xl shadow-sm transition flex items-center gap-1.5">
                        <span class="material-icons" style="font-size:16px!important;">filter_alt</span>
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ======================================================== --}}
    {{-- 4. ACTIVITY LOGS TIMELINE TABLE                          --}}
    {{-- ======================================================== --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2">
                <span class="material-icons text-slate-400" style="font-size:18px!important;">view_timeline</span>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Daftar Rekam Jejak Aktivitas</h3>
            </div>
            <span class="text-[11px] font-semibold text-slate-500">
                Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ number_format($logs->total()) }} entri
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[11px] font-bold">
                    <tr>
                        <th class="px-5 py-3.5 w-44">Waktu Kejadian</th>
                        <th class="px-5 py-3.5 w-52">Pelaksana (User)</th>
                        <th class="px-5 py-3.5 w-36">Aksi</th>
                        <th class="px-5 py-3.5">Detail Aktivitas & Deskripsi</th>
                        <th class="px-5 py-3.5 w-36">Modul / Objek</th>
                        <th class="px-5 py-3.5 w-32 text-right">Alamat IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($logs as $log)
                        @php
                            $badge = $log->action_badge;
                            $userRoleBg = match($log->user_role) {
                                'admin'    => 'bg-purple-100 text-purple-800',
                                'pimpinan' => 'bg-blue-100 text-blue-800',
                                'staf'     => 'bg-emerald-100 text-emerald-800',
                                default    => 'bg-slate-100 text-slate-700',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            {{-- 1. Timestamp --}}
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex flex-col font-mono">
                                    <span class="font-bold text-slate-800 text-[12px]">
                                        {{ $log->created_at ? $log->created_at->format('d/m/Y') : '-' }}
                                    </span>
                                    <span class="text-[11px] text-slate-500 font-semibold flex items-center gap-1 mt-0.5">
                                        <span class="material-icons text-slate-400" style="font-size:12px!important;">schedule</span>
                                        {{ $log->created_at ? $log->created_at->format('H:i:s') . ' WIB' : '-' }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 mt-0.5">
                                        {{ $log->created_at ? $log->created_at->diffForHumans() : '' }}
                                    </span>
                                </div>
                            </td>

                            {{-- 2. Pelaksana / User --}}
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-slate-700 to-slate-900 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-sm">
                                        {{ strtoupper(substr($log->user_name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-800 truncate max-w-[150px]" title="{{ $log->user_name }}">
                                            {{ $log->user_name }}
                                        </p>
                                        <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-bold uppercase {{ $userRoleBg }} mt-0.5">
                                            {{ $log->user_role }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- 3. Jenis Aksi --}}
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[11px] font-bold border {{ $badge['bg'] }} shadow-xs">
                                    <span class="material-icons" style="font-size:14px!important;">{{ $badge['icon'] }}</span>
                                    {{ $badge['label'] }}
                                </span>
                            </td>

                            {{-- 4. Deskripsi Aktivitas --}}
                            <td class="px-5 py-4">
                                <p class="text-slate-800 font-medium leading-relaxed">
                                    {{ $log->description }}
                                </p>
                            </td>

                            {{-- 5. Modul / Objek Target --}}
                            <td class="px-5 py-4 whitespace-nowrap">
                                @if($log->model_type)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-mono font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        <span class="material-icons text-slate-400" style="font-size:12px!important;">tag</span>
                                        {{ $log->model_type }} #{{ $log->model_id ?? '-' }}
                                    </span>
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>

                            {{-- 6. Alamat IP --}}
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <span class="inline-block font-mono text-[11px] px-2 py-0.5 rounded bg-slate-50 text-slate-500 border border-slate-200/60"
                                      title="{{ $log->user_agent }}">
                                    {{ $log->ip_address ?? '127.0.0.1' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16 text-slate-400">
                                <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <span class="material-icons" style="font-size:32px!important;">manage_search</span>
                                </div>
                                <h4 class="font-bold text-slate-700 text-sm">Tidak Ada Log Ditemukan</h4>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                    Tidak ada rekaman aktivitas yang sesuai dengan kriteria pencarian dan filter tanggal yang Anda pilih.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
            <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>

@endsection
