@extends('components.layouts.app')

@section('content')



{{-- Page Header --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <a href="{{ route('halamanutama') }}" class="text-slate-400 hover:text-slate-600 text-sm flex items-center gap-1 transition-colors">
                <span class="material-icons" style="font-size:16px!important;">home</span>
                Dashboard
            </a>
            <span class="text-slate-300 text-sm">/</span>
            <span class="text-slate-600 text-sm font-medium">Surat Masuk</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                <span class="material-icons text-white" style="font-size:18px!important;">move_to_inbox</span>
            </div>
            Daftar Surat Masuk
        </h1>
    </div>

    <div class="flex items-center gap-3 flex-wrap">
        {{-- Search --}}
        <form id="searchForm" method="GET" class="relative">
            <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" style="font-size:18px!important;">search</span>
            <input
                type="text"
                name="search"
                id="searchInput"
                value="{{ request('search') }}"
                placeholder="Cari surat..."
                class="pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition-all w-64"
                {{ request('search') ? 'autofocus' : '' }}
            >
        </form>
        <a href="{{ route('inputsuratmasuk') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md"
            style="background:linear-gradient(135deg,#10b981,#059669); box-shadow:0 4px 14px rgba(16,185,129,0.3);">
            <span class="material-icons" style="font-size:16px!important;">add</span>
            Input Surat Baru
        </a>
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    let searchTimeout = null;
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => searchForm.submit(), 600);
        });
    }
</script>

{{-- Table Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr style="background:linear-gradient(135deg,#0a192f,#0f3025);">
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider w-10">No</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Nomor Surat</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Tanggal</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Pengirim</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Perihal</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Tujuan</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Status Alur</th>
                    <th class="px-5 py-4 text-center text-xs font-semibold text-white/70 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($suratMasuk as $index => $surat)
                <tr class="hover:bg-slate-50/70 transition-colors duration-150 group">
                    <td class="px-5 py-3.5 text-slate-400 font-medium text-xs">
                        {{ $suratMasuk->firstItem() + $index }}
                    </td>
                    <td class="px-5 py-3.5 whitespace-nowrap">
                        <span class="font-semibold text-xs bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg border border-blue-100 whitespace-nowrap inline-block">
                            {{ $surat->nomor_surat }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs whitespace-nowrap">
                        <div class="flex items-center gap-1.5">
                            <span class="material-icons text-slate-300" style="font-size:14px!important;">calendar_today</span>
                            {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-700 text-xs font-medium max-w-[160px] truncate" title="{{ $surat->pengirim }}">
                        {{ $surat->pengirim }}
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs max-w-[200px] truncate" title="{{ $surat->perihal }}">
                        {{ $surat->perihal }}
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs max-w-[140px] truncate" title="{{ $surat->tujuan_surat }}">
                        {{ $surat->tujuan_surat }}
                    </td>
                    <td class="px-5 py-3.5 whitespace-nowrap">
                        @php
                            $st = $surat->status_surat;
                            $stColor = match($st) {
                                'Selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'Sedang Diproses' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                                'Didisposisikan' => 'bg-amber-50 text-amber-700 border-amber-200',
                                default => 'bg-blue-50 text-blue-700 border-blue-200',
                            };
                            $stIcon = match($st) {
                                'Selesai' => 'check_circle',
                                'Sedang Diproses' => 'pending',
                                'Didisposisikan' => 'assignment_ind',
                                default => 'mark_email_unread',
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-lg border whitespace-nowrap {{ $stColor }}">
                            <span class="material-icons" style="font-size:13px!important;">{{ $stIcon }}</span>
                            {{ $st }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 whitespace-nowrap">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('suratmasuk.show', $surat->id) }}"
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200 transition-all hover:scale-105"
                                title="Lihat Detail & Disposisi">
                                <span class="material-icons" style="font-size:15px!important;">visibility</span>
                            </a>
                            <a href="{{ route('disposisi.cetak', $surat->id) }}" target="_blank"
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-200 transition-all hover:scale-105"
                                title="Cetak Lembar Disposisi">
                                <span class="material-icons" style="font-size:15px!important;">print</span>
                            </a>
                            <a href="{{ route('suratmasuk.edit', $surat->id) }}"
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-50 text-amber-600 hover:bg-amber-100 border border-amber-200 transition-all hover:scale-105"
                                title="Edit">
                                <span class="material-icons" style="font-size:15px!important;">edit</span>
                            </a>
                            <form action="{{ route('suratmasuk.destroy', $surat->id) }}" method="POST" class="inline-block"
                                data-confirm-delete="Yakin ingin menghapus surat masuk '{{ $surat->nomor_surat }}'?">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 transition-all hover:scale-105"
                                    title="Hapus">
                                    <span class="material-icons" style="font-size:15px!important;">delete_outline</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                <span class="material-icons text-slate-300" style="font-size:32px!important;">inbox</span>
                            </div>
                            <p class="text-slate-500 font-medium">Belum ada data surat masuk</p>
                            <p class="text-slate-400 text-xs">
                                @if(request('search')) Tidak ada hasil untuk "{{ request('search') }}"
                                @else Klik tombol "Input Surat Baru" untuk menambahkan data
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($suratMasuk->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 flex items-center justify-between">
        <p class="text-xs text-slate-500">
            Menampilkan {{ $suratMasuk->firstItem() }}–{{ $suratMasuk->lastItem() }} dari {{ $suratMasuk->total() }} data
        </p>
        {{ $suratMasuk->withQueryString()->links('pagination::tailwind') }}
    </div>
    @else
    <div class="px-5 py-3 border-t border-slate-100">
        <p class="text-xs text-slate-400">Total {{ $suratMasuk->total() }} data</p>
    </div>
    @endif
</div>

@endsection

