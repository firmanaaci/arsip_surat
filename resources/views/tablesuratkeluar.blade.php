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
            <span class="text-slate-600 text-sm font-medium">Surat Keluar</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                <span class="material-icons text-white" style="font-size:18px!important;">outbox</span>
            </div>
            Daftar Surat Keluar
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
                class="pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-400 transition-all w-64"
                {{ request('search') ? 'autofocus' : '' }}
            >
        </form>
        <a href="{{ route('inputsuratkeluar') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md"
            style="background:linear-gradient(135deg,#f59e0b,#d97706); box-shadow:0 4px 14px rgba(245,158,11,0.35);">
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
                <tr style="background:linear-gradient(135deg,#1a1200,#3d2a00);">
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider w-10">No</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Nomor Surat</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Tanggal</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Sifat</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Lampiran</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Hal</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-white/70 uppercase tracking-wider">Tujuan</th>
                    <th class="px-5 py-4 text-center text-xs font-semibold text-white/70 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($suratKeluar as $index => $surat)
                <tr class="hover:bg-slate-50/70 transition-colors duration-150 group">
                    <td class="px-5 py-3.5 text-slate-400 font-medium text-xs">
                        {{ $suratKeluar->firstItem() + $index }}
                    </td>
                    <td class="px-5 py-3.5 whitespace-nowrap">
                        <span class="font-semibold text-xs bg-amber-50 text-amber-700 px-2.5 py-1 rounded-lg border border-amber-100 whitespace-nowrap inline-block">
                            {{ $surat->nomor_surat }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs whitespace-nowrap">
                        <div class="flex items-center gap-1.5">
                            <span class="material-icons text-slate-300" style="font-size:14px!important;">calendar_today</span>
                            {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}
                        </div>
                    </td>
                    <td class="px-5 py-3.5 whitespace-nowrap">
                        @php
                            $sifat = $surat->sifat_surat;
                            $sifatColor = match($sifat) {
                                'Rahasia','Sangat Rahasia' => 'bg-red-50 text-red-700 border-red-200',
                                'Penting','Segera' => 'bg-orange-50 text-orange-700 border-orange-200',
                                default => 'bg-slate-100 text-slate-600 border-slate-200',
                            };
                        @endphp
                        <span class="text-xs font-medium px-2.5 py-1 rounded-lg border whitespace-nowrap inline-block {{ $sifatColor }}">{{ $sifat }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs whitespace-nowrap">{{ $surat->lampiran }}</td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs max-w-[180px] truncate" title="{{ $surat->hal }}">{{ $surat->hal }}</td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs max-w-[140px] truncate" title="{{ $surat->tujuan_surat }}">{{ $surat->tujuan_surat }}</td>
                    <td class="px-5 py-3.5 whitespace-nowrap">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('suratkeluar.show', $surat->id) }}"
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200 transition-all hover:scale-105"
                                title="Lihat Detail">
                                <span class="material-icons" style="font-size:15px!important;">visibility</span>
                            </a>
                            <a href="{{ route('suratkeluar.edit', $surat->id) }}"
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-50 text-amber-600 hover:bg-amber-100 border border-amber-200 transition-all hover:scale-105"
                                title="Edit">
                                <span class="material-icons" style="font-size:15px!important;">edit</span>
                            </a>
                            <form action="{{ route('suratkeluar.destroy', $surat->id) }}" method="POST" class="inline-block"
                                data-confirm-delete="Yakin ingin menghapus surat keluar '{{ $surat->nomor_surat }}'?">
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
                                <span class="material-icons text-slate-300" style="font-size:32px!important;">outbox</span>
                            </div>
                            <p class="text-slate-500 font-medium">Belum ada data surat keluar</p>
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
    @if($suratKeluar->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 flex items-center justify-between">
        <p class="text-xs text-slate-500">
            Menampilkan {{ $suratKeluar->firstItem() }}–{{ $suratKeluar->lastItem() }} dari {{ $suratKeluar->total() }} data
        </p>
        {{ $suratKeluar->withQueryString()->links('pagination::tailwind') }}
    </div>
    @else
    <div class="px-5 py-3 border-t border-slate-100">
        <p class="text-xs text-slate-400">Total {{ $suratKeluar->total() }} data</p>
    </div>
    @endif
</div>

@endsection
