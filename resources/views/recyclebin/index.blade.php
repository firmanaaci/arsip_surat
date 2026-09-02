@extends('components.layouts.app')

@section('content')

<div>
    {{-- Page Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-slate-600 text-xs flex items-center gap-1 transition-colors">
                    <span class="material-icons" style="font-size:15px!important;">home</span>
                    Dashboard
                </a>
                <span class="text-slate-300 text-xs">/</span>
                <span class="text-slate-600 text-xs font-semibold">Tempat Sampah</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-800 flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                    <span class="material-icons text-white" style="font-size:19px!important;">delete_sweep</span>
                </div>
                Tempat Sampah (Recycle Bin & Pemulihan)
            </h1>
            <p class="text-xs text-slate-500 mt-1">Dokumen yang terhapus sementara dapat dipulihkan kembali atau dimusnahkan secara permanen.</p>
        </div>

        @if($counts['total'] > 0)
            <form action="{{ route('recyclebin.empty', ['type' => $tab]) }}" method="POST"
                  data-confirm-delete="PERINGATAN KRUSIAL: Tindakan ini akan memusnahkan SELURUH berkas fisik dan data di tab ini secara permanen dari server. Lanjutkan?">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md transition-all hover:-translate-y-0.5">
                    <span class="material-icons" style="font-size:16px!important;">delete_forever</span>
                    Kosongkan Tab Ini ({{ $counts[$tab] ?? 0 }})
                </button>
            </form>
        @endif
    </div>

    {{-- Tabs Navigation --}}
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 mb-6 pb-2">
        <a href="{{ route('recyclebin.index', ['tab' => 'masuk']) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all
               {{ $tab === 'masuk' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span class="material-icons" style="font-size:16px!important;">move_to_inbox</span>
            Surat Masuk
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $tab === 'masuk' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">
                {{ $counts['masuk'] }}
            </span>
        </a>

        <a href="{{ route('recyclebin.index', ['tab' => 'keluar']) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all
               {{ $tab === 'keluar' ? 'bg-amber-600 text-white shadow-md shadow-amber-500/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span class="material-icons" style="font-size:16px!important;">outbox</span>
            Surat Keluar
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $tab === 'keluar' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">
                {{ $counts['keluar'] }}
            </span>
        </a>

        <a href="{{ route('recyclebin.index', ['tab' => 'disposisi']) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all
               {{ $tab === 'disposisi' ? 'bg-cyan-600 text-white shadow-md shadow-cyan-500/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span class="material-icons" style="font-size:16px!important;">assignment</span>
            Lembar Disposisi
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $tab === 'disposisi' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">
                {{ $counts['disposisi'] }}
            </span>
        </a>
    </div>

    {{-- Search Bar --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm mb-6 flex flex-col sm:flex-row items-center justify-between gap-3">
        <form method="GET" action="{{ route('recyclebin.index') }}" class="flex items-center gap-3 w-full sm:w-auto flex-1">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="relative flex-1 sm:max-w-md">
                <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" style="font-size:18px!important;">search</span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari dalam tempat sampah..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
            </div>
            <button type="submit" class="px-3.5 py-2 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition">
                Cari
            </button>
            @if($search)
                <a href="{{ route('recyclebin.index', ['tab' => $tab]) }}" class="text-xs text-rose-500 hover:underline">Reset</a>
            @endif
        </form>
    </div>

    {{-- ======================================================== --}}
    {{-- TAB 1: SURAT MASUK TERHAPUS                              --}}
    {{-- ======================================================== --}}
    @if($tab === 'masuk')
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[11px] font-bold">
                        <tr>
                            <th class="px-5 py-3.5">Nomor Surat & Asal</th>
                            <th class="px-5 py-3.5">Perihal</th>
                            <th class="px-5 py-3.5">Berkas Fisik</th>
                            <th class="px-5 py-3.5">Waktu Dihapus</th>
                            <th class="px-5 py-3.5 text-right">Opsi Pemulihan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($trashedMasuk as $sm)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-5 py-3.5">
                                    <p class="font-bold text-slate-800">{{ $sm->nomor_surat }}</p>
                                    <p class="text-[11px] text-slate-400">Dari: {{ $sm->pengirim }}</p>
                                </td>
                                <td class="px-5 py-3.5 max-w-xs truncate">
                                    {{ $sm->perihal }}
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if($sm->file)
                                        <span class="inline-flex items-center gap-1 text-[11px] text-emerald-600 font-semibold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">
                                            <span class="material-icons" style="font-size:13px!important;">attach_file</span>
                                            Ada File
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[11px]">Tanpa File</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-slate-500 font-mono text-[11px]">
                                    {{ $sm->deleted_at ? $sm->deleted_at->format('d/m/Y H:i') : '-' }}
                                    <span class="block text-[10px] text-slate-400">({{ $sm->deleted_at ? $sm->deleted_at->diffForHumans() : '' }})</span>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        {{-- Restore Button --}}
                                        <form action="{{ route('recyclebin.restore', ['type' => 'masuk', 'id' => $sm->id]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl transition shadow-sm"
                                                title="Pulihkan Surat">
                                                <span class="material-icons" style="font-size:14px!important;">restore_from_trash</span>
                                                Pulihkan
                                            </button>
                                        </form>

                                        {{-- Force Delete Button --}}
                                        <form action="{{ route('recyclebin.forceDelete', ['type' => 'masuk', 'id' => $sm->id]) }}" method="POST" class="inline"
                                            data-confirm-delete="Hapus PERMANEN surat '{{ $sm->nomor_surat }}'? Berkas fisik di storage juga akan dimusnahkan. Tindakan TIDAK DAPAT dibatalkan.">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition"
                                                title="Hapus Permanen">
                                                <span class="material-icons" style="font-size:14px!important;">delete_forever</span>
                                                Musnahkan
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-slate-400">
                                    <span class="material-icons text-slate-300" style="font-size:36px!important;">delete_outline</span>
                                    <p class="mt-1">Tempat sampah surat masuk kosong.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($trashedMasuk->hasPages())
                <div class="px-5 py-3 border-t border-slate-100">
                    {{ $trashedMasuk->links() }}
                </div>
            @endif
        </div>
    @endif

    {{-- ======================================================== --}}
    {{-- TAB 2: SURAT KELUAR TERHAPUS                             --}}
    {{-- ======================================================== --}}
    @if($tab === 'keluar')
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[11px] font-bold">
                        <tr>
                            <th class="px-5 py-3.5">Nomor Surat & Tujuan</th>
                            <th class="px-5 py-3.5">Perihal / Hal</th>
                            <th class="px-5 py-3.5">Klasifikasi</th>
                            <th class="px-5 py-3.5">Waktu Dihapus</th>
                            <th class="px-5 py-3.5 text-right">Opsi Pemulihan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($trashedKeluar as $sk)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-5 py-3.5">
                                    <p class="font-bold text-slate-800">{{ $sk->nomor_surat }}</p>
                                    <p class="text-[11px] text-slate-400">Kepada: {{ $sk->tujuan_surat }}</p>
                                </td>
                                <td class="px-5 py-3.5 max-w-xs truncate">
                                    {{ $sk->hal }}
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if($sk->kode_klasifikasi)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                            {{ $sk->kode_klasifikasi }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-slate-500 font-mono text-[11px]">
                                    {{ $sk->deleted_at ? $sk->deleted_at->format('d/m/Y H:i') : '-' }}
                                    <span class="block text-[10px] text-slate-400">({{ $sk->deleted_at ? $sk->deleted_at->diffForHumans() : '' }})</span>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <form action="{{ route('recyclebin.restore', ['type' => 'keluar', 'id' => $sk->id]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl transition shadow-sm"
                                                title="Pulihkan Surat">
                                                <span class="material-icons" style="font-size:14px!important;">restore_from_trash</span>
                                                Pulihkan
                                            </button>
                                        </form>

                                        <form action="{{ route('recyclebin.forceDelete', ['type' => 'keluar', 'id' => $sk->id]) }}" method="POST" class="inline"
                                            data-confirm-delete="Hapus PERMANEN surat keluar '{{ $sk->nomor_surat }}'? Berkas lampiran di storage juga akan dihapus. Tindakan TIDAK DAPAT dibatalkan.">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition"
                                                title="Hapus Permanen">
                                                <span class="material-icons" style="font-size:14px!important;">delete_forever</span>
                                                Musnahkan
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-slate-400">
                                    <span class="material-icons text-slate-300" style="font-size:36px!important;">delete_outline</span>
                                    <p class="mt-1">Tempat sampah surat keluar kosong.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($trashedKeluar->hasPages())
                <div class="px-5 py-3 border-t border-slate-100">
                    {{ $trashedKeluar->links() }}
                </div>
            @endif
        </div>
    @endif

    {{-- ======================================================== --}}
    {{-- TAB 3: DISPOSISI TERHAPUS                                --}}
    {{-- ======================================================== --}}
    @if($tab === 'disposisi')
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[11px] font-bold">
                        <tr>
                            <th class="px-5 py-3.5">ID Disposisi & Surat</th>
                            <th class="px-5 py-3.5">Tujuan Seksi</th>
                            <th class="px-5 py-3.5">Petunjuk Instruksi</th>
                            <th class="px-5 py-3.5">Waktu Dihapus</th>
                            <th class="px-5 py-3.5 text-right">Opsi Pemulihan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($trashedDisposisi as $dsp)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-5 py-3.5">
                                    <p class="font-bold text-slate-800">#DSP-{{ $dsp->id }}</p>
                                    <p class="text-[11px] text-slate-400 truncate max-w-xs">
                                        {{ $dsp->suratMasuk ? $dsp->suratMasuk->nomor_surat : 'Surat ID #' . $dsp->surat_masuk_id }}
                                    </p>
                                </td>
                                <td class="px-5 py-3.5 font-semibold text-slate-700">
                                    {{ $dsp->tujuan_seksi }}
                                </td>
                                <td class="px-5 py-3.5 max-w-xs truncate">
                                    {{ $dsp->petunjuk_disposisi }}
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-slate-500 font-mono text-[11px]">
                                    {{ $dsp->deleted_at ? $dsp->deleted_at->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <form action="{{ route('recyclebin.restore', ['type' => 'disposisi', 'id' => $dsp->id]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl transition shadow-sm">
                                                <span class="material-icons" style="font-size:14px!important;">restore_from_trash</span>
                                                Pulihkan
                                            </button>
                                        </form>

                                        <form action="{{ route('recyclebin.forceDelete', ['type' => 'disposisi', 'id' => $dsp->id]) }}" method="POST" class="inline"
                                            data-confirm-delete="Hapus PERMANEN lembar disposisi #DSP-{{ $dsp->id }}? Tindakan TIDAK DAPAT dibatalkan.">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition">
                                                <span class="material-icons" style="font-size:14px!important;">delete_forever</span>
                                                Musnahkan
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-slate-400">
                                    <span class="material-icons text-slate-300" style="font-size:36px!important;">delete_outline</span>
                                    <p class="mt-1">Tempat sampah disposisi kosong.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($trashedDisposisi->hasPages())
                <div class="px-5 py-3 border-t border-slate-100">
                    {{ $trashedDisposisi->links() }}
                </div>
            @endif
        </div>
    @endif

</div>

@endsection
