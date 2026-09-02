@extends('components.layouts.app')

@section('content')

<div x-data="{
    showDisposisiModal: false,
    showTindakLanjutModal: false,
    tindakLanjutUrl: '',
    currentStatus: 'Menunggu Tindak Lanjut',
    currentCatatan: '',
    openTindakLanjut(url, status, catatan) {
        this.tindakLanjutUrl = url;
        this.currentStatus = status || 'Menunggu Tindak Lanjut';
        this.currentCatatan = catatan || '';
        this.showTindakLanjutModal = true;
    }
}">



{{-- Page Header --}}
<div class="mb-6">
    <div class="flex items-center gap-2 mb-2">
        <a href="{{ route('halamanutama') }}" class="text-slate-400 hover:text-slate-600 text-sm flex items-center gap-1 transition-colors">
            <span class="material-icons" style="font-size:16px!important;">home</span>Dashboard
        </a>
        <span class="text-slate-300">/</span>
        <a href="{{ route('suratmasuk.index') }}" class="text-slate-400 hover:text-slate-600 text-sm transition-colors">Surat Masuk</a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-600 text-sm font-medium">Detail & Disposisi</span>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                <span class="material-icons text-white" style="font-size:18px!important;">move_to_inbox</span>
            </div>
            Detail & Disposisi Surat Masuk
        </h1>

        <div class="flex items-center gap-2 flex-wrap">
            {{-- Tombol Cetak Lembar Disposisi --}}
            <a href="{{ route('disposisi.cetak', $surat->id) }}" target="_blank"
                class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 transition-all shadow-sm">
                <span class="material-icons text-emerald-600" style="font-size:16px!important;">print</span>
                Cetak Lembar Disposisi
            </a>

            {{-- Tombol Buat Disposisi --}}
            <button type="button" @click="showDisposisiModal = true"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white rounded-xl shadow-sm transition-all hover:-translate-y-0.5"
                style="background:linear-gradient(135deg,#3b82f6,#2563eb); box-shadow:0 4px 14px rgba(59,130,246,0.35);">
                <span class="material-icons" style="font-size:16px!important;">add_task</span>
                + Buat Disposisi
            </button>

            {{-- Edit & Kembali --}}
            <a href="{{ route('suratmasuk.edit', $surat->id) }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-semibold text-amber-700 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-100 transition-all">
                <span class="material-icons" style="font-size:16px!important;">edit</span>
                Edit
            </a>
            <a href="{{ route('suratmasuk.index') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                <span class="material-icons" style="font-size:16px!important;">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>
</div>

{{-- ===== WORKFLOW PROGRESS TRACKER ===== --}}
@php
    $hasDisposisi = $surat->disposisis->count() > 0;
    $isProcessing = $surat->status_surat === 'Sedang Diproses' || $surat->disposisis->where('status', 'Sedang Diproses')->count() > 0;
    $isCompleted = $surat->status_surat === 'Selesai' || ($hasDisposisi && $surat->disposisis->where('status', '!=', 'Selesai')->count() === 0);
@endphp
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4 flex items-center gap-1.5">
        <span class="material-icons text-blue-500" style="font-size:16px!important;">timeline</span>
        Alur Proses Surat Masuk
    </p>
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
        {{-- Step 1 --}}
        <div class="flex items-center gap-3 p-3 rounded-xl border bg-emerald-50/70 border-emerald-200 text-emerald-800">
            <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">✓</div>
            <div class="min-w-0">
                <p class="text-xs font-bold leading-tight">1. Input Surat</p>
                <p class="text-[11px] text-emerald-600">Surat terdaftar</p>
            </div>
        </div>
        {{-- Step 2 --}}
        <div class="flex items-center gap-3 p-3 rounded-xl border {{ $hasDisposisi ? 'bg-emerald-50/70 border-emerald-200 text-emerald-800' : 'bg-blue-50 border-blue-200 text-blue-800' }}">
            <div class="w-7 h-7 rounded-lg {{ $hasDisposisi ? 'bg-emerald-600 text-white' : 'bg-blue-600 text-white' }} flex items-center justify-center font-bold text-xs flex-shrink-0">
                {{ $hasDisposisi ? '✓' : '2' }}
            </div>
            <div class="min-w-0">
                <p class="text-xs font-bold leading-tight">2. Disposisi</p>
                <p class="text-[11px] {{ $hasDisposisi ? 'text-emerald-600' : 'text-blue-600' }}">
                    {{ $hasDisposisi ? $surat->disposisis->count() . ' Disposisi dibuat' : 'Menunggu pimpinan' }}
                </p>
            </div>
        </div>
        {{-- Step 3 --}}
        <div class="flex items-center gap-3 p-3 rounded-xl border {{ $isCompleted ? 'bg-emerald-50/70 border-emerald-200 text-emerald-800' : ($isProcessing ? 'bg-cyan-50 border-cyan-200 text-cyan-800' : 'bg-slate-50 border-slate-200 text-slate-400') }}">
            <div class="w-7 h-7 rounded-lg {{ $isCompleted ? 'bg-emerald-600 text-white' : ($isProcessing ? 'bg-cyan-600 text-white animate-pulse' : 'bg-slate-300 text-white') }} flex items-center justify-center font-bold text-xs flex-shrink-0">
                {{ $isCompleted ? '✓' : '3' }}
            </div>
            <div class="min-w-0">
                <p class="text-xs font-bold leading-tight">3. Tindak Lanjut</p>
                <p class="text-[11px] {{ $isCompleted ? 'text-emerald-600' : ($isProcessing ? 'text-cyan-600 font-semibold' : 'text-slate-400') }}">
                    {{ $isCompleted ? 'Selesai diproses' : ($isProcessing ? 'Sedang dikerjakan' : 'Belum diproses') }}
                </p>
            </div>
        </div>
        {{-- Step 4 --}}
        <div class="flex items-center gap-3 p-3 rounded-xl border {{ $isCompleted ? 'bg-emerald-50/70 border-emerald-200 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
            <div class="w-7 h-7 rounded-lg {{ $isCompleted ? 'bg-emerald-600 text-white' : 'bg-slate-300 text-white' }} flex items-center justify-center font-bold text-xs flex-shrink-0">
                {{ $isCompleted ? '✓' : '4' }}
            </div>
            <div class="min-w-0">
                <p class="text-xs font-bold leading-tight">4. Arsip Tuntas</p>
                <p class="text-[11px] {{ $isCompleted ? 'text-emerald-600 font-semibold' : 'text-slate-400' }}">
                    {{ $isCompleted ? 'Tuntas & diarsipkan' : 'Menunggu selesai' }}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Main Details Card --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

    {{-- Card Header --}}
    <div class="px-7 py-5 border-b border-slate-100 flex items-center justify-between" style="background:linear-gradient(135deg,#eff6ff,#f0fdf4);">
        <div class="flex items-center gap-3">
            <div>
                <p class="text-xs text-slate-500">Nomor Surat</p>
                <p class="font-bold text-slate-800 text-lg tracking-wide">{{ $surat->nomor_surat }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @php
                $statusSurat = $surat->status_surat;
                $statusColor = match($statusSurat) {
                    'Selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                    'Sedang Diproses' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
                    'Didisposisikan' => 'bg-amber-100 text-amber-800 border-amber-300',
                    default => 'bg-blue-100 text-blue-800 border-blue-300',
                };
            @endphp
            <span class="text-xs font-semibold px-3 py-1.5 rounded-full border {{ $statusColor }}">
                Status: {{ $statusSurat }}
            </span>

            @php
                $sifat = $surat->sifat_surat;
                $sifatColor = match($sifat) {
                    'Rahasia','Sangat Rahasia' => 'bg-red-100 text-red-700 border-red-200',
                    'Penting','Segera' => 'bg-orange-100 text-orange-700 border-orange-200',
                    default => 'bg-slate-100 text-slate-600 border-slate-200',
                };
            @endphp
            <span class="text-xs font-semibold px-3 py-1.5 rounded-full border {{ $sifatColor }}">{{ $sifat }}</span>
        </div>
    </div>

    {{-- Detail Fields --}}
    <div class="p-7">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- Tanggal --}}
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="material-icons text-blue-400" style="font-size:16px!important;">calendar_today</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Tanggal Surat</p>
                    <p class="text-sm font-semibold text-slate-800">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y') }}</p>
                </div>
            </div>

            {{-- Pengirim --}}
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="material-icons text-emerald-400" style="font-size:16px!important;">person</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Pengirim</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $surat->pengirim }}</p>
                </div>
            </div>

            {{-- Perihal --}}
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-violet-50 border border-violet-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="material-icons text-violet-400" style="font-size:16px!important;">subject</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Perihal</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $surat->perihal }}</p>
                </div>
            </div>

            {{-- Kategori --}}
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-50 border border-amber-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="material-icons text-amber-400" style="font-size:16px!important;">label</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Kategori</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $surat->kategori }}</p>
                </div>
            </div>

            {{-- Tujuan Surat Awal --}}
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-rose-50 border border-rose-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="material-icons text-rose-400" style="font-size:16px!important;">send</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Tujuan / Diteruskan</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $surat->tujuan_surat }}</p>
                </div>
            </div>

            {{-- Petunjuk Awal --}}
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="material-icons text-indigo-400" style="font-size:16px!important;">assignment</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Petunjuk Awal</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $surat->petunjuk }}</p>
                </div>
            </div>

        </div>

        {{-- Catatan Surat Masuk --}}
        @if($surat->catatan)
        <div class="mt-6 bg-slate-50 rounded-xl p-4 border border-slate-200/80">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1 flex items-center gap-1.5">
                <span class="material-icons" style="font-size:14px!important;">notes</span>Catatan Masuk
            </p>
            <p class="text-sm text-slate-700 whitespace-pre-line">{{ $surat->catatan }}</p>
        </div>
        @endif
    </div>
</div>

{{-- Smart Digital Verification & QR Code Banner --}}
<div class="mb-6 p-5 rounded-2xl border border-emerald-200/80 shadow-sm relative overflow-hidden bg-white"
    style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
        <div class="flex items-start gap-4">
            {{-- QR Code Image --}}
            @php
                $verifyUrl = \App\Services\QrCodeService::getVerificationUrl($surat->kode_verifikasi ?? $surat->nomor_surat);
                $qrSvgUrl = \App\Services\QrCodeService::generateSvg($verifyUrl, 140);
            @endphp
            <div class="w-24 h-24 sm:w-28 sm:h-28 bg-white p-2 rounded-2xl border border-emerald-200 shadow-sm flex items-center justify-center flex-shrink-0">
                <img src="{{ $qrSvgUrl }}" alt="QR Code Verifikasi" class="w-full h-full object-contain">
            </div>
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                        <span class="material-icons" style="font-size:13px!important;">verified</span>
                        QR Code Terverifikasi Sah
                    </span>
                    @if($surat->kode_klasifikasi)
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-mono font-semibold bg-blue-100 text-blue-800">
                        Kode: {{ $surat->kode_klasifikasi }}
                    </span>
                    @endif
                </div>
                <h3 class="text-base font-bold text-slate-800">Verifikasi Keaslian Arsip Surat Masuk</h3>
                <p class="text-xs text-slate-600 mt-0.5 max-w-lg">
                    Pindai QR Code untuk memvalidasi keaslian dokumen resmi di Portal Publik Kementerian Agama.
                </p>
                <p class="text-[11px] font-mono text-emerald-700 font-semibold mt-1">
                    UUID: {{ $surat->kode_verifikasi ?? '-' }}
                </p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 w-full md:w-auto">
            <a href="{{ $verifyUrl }}" target="_blank"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2.5 text-xs font-bold text-white rounded-xl shadow-sm transition-all hover:scale-105"
                style="background: linear-gradient(135deg, #059669, #047857);">
                <span class="material-icons" style="font-size:16px!important;">open_in_new</span>
                Buka Halaman Verifikasi
            </a>
            <button type="button" onclick="navigator.clipboard.writeText('{{ $verifyUrl }}'); alert('Tautan verifikasi berhasil disalin!')"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                <span class="material-icons" style="font-size:16px!important;">content_copy</span>
                Salin URL
            </button>
        </div>
    </div>
</div>

{{-- ===== RIWAYAT DISPOSISI & TINDAK LANJUT ===== --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
    <div class="px-7 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-gradient-to-r from-slate-50 to-white">
        <div>
            <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <span class="material-icons text-emerald-600" style="font-size:20px!important;">assignment_turned_in</span>
                Daftar Instruksi Disposisi & Laporan Tindak Lanjut
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Pelacakan instruksi pimpinan kepada unit/seksi kerja beserta laporan penyelesaian.</p>
        </div>
        <button type="button" @click="showDisposisiModal = true"
            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold text-white rounded-xl shadow-sm hover:opacity-90 transition"
            style="background:linear-gradient(135deg,#10b981,#059669);">
            <span class="material-icons" style="font-size:15px!important;">add</span>
            + Tambah Disposisi
        </button>
    </div>

    <div class="p-7">
        @if($surat->disposisis->count() > 0)
            <div class="space-y-5">
                @foreach($surat->disposisis as $index => $disp)
                    @php
                        $dStatus = $disp->status;
                        $badgeStyle = match($dStatus) {
                            'Selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            'Sedang Diproses' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
                            default => 'bg-amber-100 text-amber-800 border-amber-200',
                        };
                    @endphp
                    <div class="rounded-2xl border border-slate-200 p-5 bg-gradient-to-br from-white to-slate-50/50 hover:shadow-md transition">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <span class="w-6 h-6 rounded-full bg-slate-800 text-white text-xs font-bold flex items-center justify-center">
                                    #{{ $index + 1 }}
                                </span>
                                <span class="font-bold text-slate-800 text-sm">
                                    {{ $disp->tujuan_seksi }}
                                </span>
                                <span class="text-xs text-slate-400 font-medium">
                                    (Oleh: {{ $disp->pemberi_disposisi }})
                                </span>
                                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border bg-slate-100 text-slate-700">
                                    Sifat: {{ $disp->sifat_disposisi }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $badgeStyle }}">
                                    {{ $dStatus }}
                                </span>
                            </div>
                        </div>

                        {{-- Instruksi & Catatan --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
                            <div class="bg-blue-50/70 rounded-xl p-3.5 border border-blue-100">
                                <p class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-1 flex items-center gap-1">
                                    <span class="material-icons" style="font-size:14px!important;">task_alt</span>
                                    Petunjuk / Instruksi:
                                </p>
                                <p class="text-sm font-semibold text-slate-800">{{ $disp->petunjuk_disposisi }}</p>
                                @if($disp->catatan_disposisi)
                                    <p class="text-xs text-slate-600 mt-2 italic bg-white/80 p-2 rounded-lg border border-blue-100">
                                        "{{ $disp->catatan_disposisi }}"
                                    </p>
                                @endif
                                <p class="text-[11px] text-slate-400 mt-2">
                                    Diterbitkan: {{ \Carbon\Carbon::parse($disp->tanggal_disposisi)->format('d M Y') }}
                                </p>
                            </div>

                            <div class="bg-emerald-50/60 rounded-xl p-3.5 border border-emerald-100">
                                <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-1 flex items-center gap-1">
                                    <span class="material-icons" style="font-size:14px!important;">edit_note</span>
                                    Laporan Hasil Tindak Lanjut:
                                </p>
                                @if($disp->catatan_tindak_lanjut)
                                    <p class="text-xs text-slate-700 whitespace-pre-line bg-white/80 p-2.5 rounded-lg border border-emerald-100">
                                        {{ $disp->catatan_tindak_lanjut }}
                                    </p>
                                    @if($disp->tgl_selesai)
                                        <p class="text-[11px] text-emerald-600 font-semibold mt-2">
                                            ✓ Diselesaikan pada: {{ \Carbon\Carbon::parse($disp->tgl_selesai)->format('d M Y, H:i') }} WIB
                                        </p>
                                    @endif
                                @else
                                    <p class="text-xs text-slate-400 italic py-2">
                                        Belum ada catatan laporan hasil tindak lanjut dari seksi/staf terkait.
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Action buttons for this disposition --}}
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                            <span class="text-xs text-slate-400">
                                ID Disposisi: #DSP-{{ $disp->id }}
                            </span>
                            <div class="flex items-center gap-2">
                                <button type="button"
                                    @click="openTindakLanjut('{{ route('disposisi.updateStatus', $disp->id) }}', '{{ $disp->status }}', '{{ addslashes($disp->catatan_tindak_lanjut ?? '') }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-cyan-800 bg-cyan-50 border border-cyan-200 rounded-xl hover:bg-cyan-100 transition">
                                    <span class="material-icons" style="font-size:14px!important;">update</span>
                                    Update Tindak Lanjut
                                </button>

                                <form action="{{ route('disposisi.destroy', $disp->id) }}" method="POST" class="inline"
                                    data-confirm-delete="Yakin ingin menghapus lembar disposisi #DSP-{{ $disp->id }} ini?">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-red-600 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition">
                                        <span class="material-icons" style="font-size:14px!important;">delete_outline</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 px-4 bg-slate-50/70 rounded-2xl border border-dashed border-slate-200">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center mx-auto mb-3">
                    <span class="material-icons" style="font-size:24px!important;">assignment_late</span>
                </div>
                <p class="font-bold text-slate-700 text-sm">Belum Ada Lembar Disposisi</p>
                <p class="text-xs text-slate-400 mt-1 max-w-md mx-auto">
                    Surat masuk ini belum diberikan instruksi disposisi resmi oleh pimpinan. Klik tombol di bawah untuk meneruskan disposisi ke seksi kerja.
                </p>
                <button type="button" @click="showDisposisiModal = true"
                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-white rounded-xl shadow-sm hover:opacity-95 transition"
                    style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                    <span class="material-icons" style="font-size:16px!important;">add_task</span>
                    + Buat Disposisi Sekarang
                </button>
            </div>
        @endif
    </div>
</div>

{{-- ===== LAMPIRAN FILE ===== --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    {{-- Section Header --}}
    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center">
            <span class="material-icons text-blue-500" style="font-size:16px!important;">folder_open</span>
        </div>
        <div>
            <p class="text-sm font-bold text-slate-700">Lampiran Berkas</p>
            <p class="text-[10px] text-slate-400">Pratinjau & integritas dokumen digital</p>
        </div>
    </div>

    <div class="p-6">
    @php
        $fileExists = $surat->file && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat->file);
    @endphp

    @if($fileExists)
        @php
            $fileUrl = asset('storage/' . $surat->file);
            $ext = strtolower(pathinfo($surat->file, PATHINFO_EXTENSION));
            $isPdf = $ext === 'pdf';
            $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
            $isWord = in_array($ext, ['doc','docx']);
            $isExcel = in_array($ext, ['xls','xlsx','csv']);
            $canPreview = $isPdf || $isImage;
            $filePath = storage_path('app/public/' . $surat->file);
            $smFileInfo = [
                'size' => file_exists($filePath) ? number_format(filesize($filePath) / 1024, 2) . ' KB' : '-',
                'mime' => file_exists($filePath) ? mime_content_type($filePath) : '-',
                'hash' => file_exists($filePath) ? hash_file('sha256', $filePath) : '-',
            ];
        @endphp

        {{-- File Integrity Fingerprint Bar --}}
        <div class="mb-5 rounded-xl bg-slate-50 border border-slate-200/80 overflow-hidden">
            <div class="px-4 py-2.5 border-b border-slate-200/80">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Integritas & Metadata Teknis</p>
            </div>
            <div class="p-4 flex flex-col gap-3 text-xs">
                {{-- Row 1: Size + Format (2 columns, no overflow) --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-slate-400 flex-shrink-0" style="font-size:15px!important;">sd_card</span>
                        <div class="min-w-0">
                            <span class="text-slate-400 block text-[10px] uppercase font-semibold">Ukuran Berkas</span>
                            <span class="font-bold text-slate-700">{{ $smFileInfo['size'] }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-slate-400 flex-shrink-0" style="font-size:15px!important;">description</span>
                        <div class="min-w-0">
                            <span class="text-slate-400 block text-[10px] uppercase font-semibold">Format</span>
                            <span class="font-bold text-slate-700 uppercase">{{ $ext }}</span>
                            <span class="block text-slate-500 text-[10px] truncate" title="{{ $smFileInfo['mime'] }}">{{ $smFileInfo['mime'] }}</span>
                        </div>
                    </div>
                </div>
                {{-- Row 2: SHA-256 full width --}}
                <div class="border-t border-slate-200/80 pt-3 flex items-start gap-2">
                    <span class="material-icons text-slate-400 flex-shrink-0 mt-0.5" style="font-size:15px!important;">fingerprint</span>
                    <div class="min-w-0 flex-1">
                        <span class="text-slate-400 block text-[10px] uppercase font-semibold mb-0.5">SHA-256 Checksum</span>
                        <span class="font-mono text-[10px] text-slate-600 break-all leading-relaxed">{{ $smFileInfo['hash'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($canPreview)
            {{-- Toolbar for previewable files --}}
            <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                <div class="flex items-center gap-2">
                    <a href="{{ $fileUrl }}" target="_blank"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white rounded-xl transition-all hover:-translate-y-0.5"
                        style="background:linear-gradient(135deg,#3b82f6,#2563eb); box-shadow:0 3px 10px rgba(59,130,246,0.3);">
                        <span class="material-icons" style="font-size:14px!important;">open_in_new</span>
                        Buka Tab Baru
                    </a>
                    <a href="{{ $fileUrl }}" download
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                        <span class="material-icons" style="font-size:14px!important;">download</span>
                        Download
                    </a>
                </div>
                <button type="button" onclick="toggleViewerFullscreenSM()"
                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                    <span class="material-icons" style="font-size:14px!important;">fullscreen</span>
                    Layar Penuh
                </button>
            </div>

            {{-- Inline Preview --}}
            <div id="document-viewer-box-sm" class="rounded-xl overflow-hidden border border-slate-200 transition-all duration-300">
                @if($isPdf)
                <div class="flex items-center justify-between px-4 py-2.5 bg-slate-800 border-b border-slate-700">
                    <span class="flex items-center gap-2 text-xs font-medium text-white">
                        <span class="material-icons text-blue-400" style="font-size:15px!important;">picture_as_pdf</span>
                        Pratinjau PDF
                    </span>
                    <span class="text-[11px] font-mono text-slate-400 truncate max-w-[200px]">{{ basename($surat->file) }}</span>
                </div>
                <div style="height:640px;">
                    <iframe src="{{ $fileUrl }}#toolbar=1&navpanes=0" class="w-full h-full border-0"></iframe>
                </div>
                @elseif($isImage)
                <div class="p-6 bg-slate-900/95 flex items-center justify-center" style="min-height:420px;">
                    <img src="{{ $fileUrl }}" alt="Preview surat" class="max-w-full max-h-[600px] rounded-xl object-contain shadow-2xl">
                </div>
                @endif
            </div>

        @else
            {{-- Office File Showcase Card --}}
            @if ($isWord)
                <div class="rounded-2xl border border-blue-200 overflow-hidden bg-gradient-to-br from-blue-50 via-blue-100/60 to-blue-50">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 p-6">
                        <div class="w-16 h-16 rounded-2xl bg-white shadow-lg border border-white/80 flex items-center justify-center flex-shrink-0">
                            <span class="material-icons text-blue-600" style="font-size:34px!important;">article</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border bg-blue-100 text-blue-800 border-blue-200">
                                    .{{ strtoupper($ext) }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium">Microsoft Word Document</span>
                            </div>
                            <p class="text-sm font-bold text-slate-800 truncate">{{ basename($surat->file) }}</p>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Format ini tidak dapat dipratinjau langsung di browser. Unduh berkas untuk membuka menggunakan Microsoft Office atau aplikasi serupa.
                            </p>
                        </div>
                        <div class="flex-shrink-0 w-full sm:w-auto">
                            <a href="{{ $fileUrl }}" download
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl transition-all hover:scale-105 active:scale-95 bg-gradient-to-r from-blue-500 to-blue-600 shadow-md shadow-blue-500/30">
                                <span class="material-icons" style="font-size:17px!important;">download</span>
                                Download {{ strtoupper($ext) }}
                            </a>
                        </div>
                    </div>
                </div>
            @elseif ($isExcel)
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-gradient-to-br from-emerald-50 via-emerald-100/60 to-emerald-50">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 p-6">
                        <div class="w-16 h-16 rounded-2xl bg-white shadow-lg border border-white/80 flex items-center justify-center flex-shrink-0">
                            <span class="material-icons text-emerald-600" style="font-size:34px!important;">table_chart</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border bg-emerald-100 text-emerald-800 border-emerald-200">
                                    .{{ strtoupper($ext) }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium">Microsoft Excel Spreadsheet</span>
                            </div>
                            <p class="text-sm font-bold text-slate-800 truncate">{{ basename($surat->file) }}</p>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Format ini tidak dapat dipratinjau langsung di browser. Unduh berkas untuk membuka menggunakan Microsoft Office atau aplikasi serupa.
                            </p>
                        </div>
                        <div class="flex-shrink-0 w-full sm:w-auto">
                            <a href="{{ $fileUrl }}" download
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl transition-all hover:scale-105 active:scale-95 bg-gradient-to-r from-emerald-500 to-emerald-600 shadow-md shadow-emerald-500/30">
                                <span class="material-icons" style="font-size:17px!important;">download</span>
                                Download {{ strtoupper($ext) }}
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="rounded-2xl border border-slate-200 overflow-hidden bg-gradient-to-br from-slate-50 via-slate-100/60 to-slate-50">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 p-6">
                        <div class="w-16 h-16 rounded-2xl bg-white shadow-lg border border-white/80 flex items-center justify-center flex-shrink-0">
                            <span class="material-icons text-slate-600" style="font-size:34px!important;">description</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border bg-slate-100 text-slate-700 border-slate-200">
                                    .{{ strtoupper($ext) }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium">Dokumen Arsip</span>
                            </div>
                            <p class="text-sm font-bold text-slate-800 truncate">{{ basename($surat->file) }}</p>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Format ini tidak dapat dipratinjau langsung di browser. Unduh berkas untuk membuka menggunakan Microsoft Office atau aplikasi serupa.
                            </p>
                        </div>
                        <div class="flex-shrink-0 w-full sm:w-auto">
                            <a href="{{ $fileUrl }}" download
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl transition-all hover:scale-105 active:scale-95 bg-gradient-to-r from-slate-600 to-slate-700 shadow-md shadow-slate-500/30">
                                <span class="material-icons" style="font-size:17px!important;">download</span>
                                Download {{ strtoupper($ext) }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endif

    @elseif($surat->file)
        <div class="flex items-center justify-between gap-4 p-4 bg-amber-50 rounded-xl border border-amber-200">
            <div class="flex items-center gap-3">
                <span class="material-icons text-amber-500" style="font-size:22px!important;">warning_amber</span>
                <div>
                    <p class="text-sm font-bold text-amber-800">File tidak ditemukan di server</p>
                    <p class="text-xs text-amber-600 mt-0.5">
                        <code class="bg-amber-100 px-1.5 py-0.5 rounded text-amber-700">{{ $surat->file }}</code>
                        belum diunggah.
                    </p>
                </div>
            </div>
            <a href="{{ route('suratmasuk.edit', $surat->id) }}"
               class="flex-shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold bg-amber-600 text-white rounded-xl hover:bg-amber-700 transition-all">
                <span class="material-icons" style="font-size:14px!important;">upload</span>
                Upload
            </a>
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-10 px-4 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-center">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
                <span class="material-icons text-slate-400" style="font-size:24px!important;">file_present</span>
            </div>
            <p class="text-sm font-semibold text-slate-500">Tidak ada file terlampir</p>
            <p class="text-xs text-slate-400 mt-1">File surat belum diunggah untuk dokumen ini.</p>
        </div>
    @endif
    </div>
</div>


{{-- ============================================================ --}}
{{-- MODAL 1: BUAT DISPOSISI BARU                                 --}}
{{-- ============================================================ --}}
<div x-show="showDisposisiModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4"
     x-cloak>
    
    <div @click.away="showDisposisiModal = false"
         class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-xl overflow-hidden my-8">
        
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-blue-50 to-white">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center">
                    <span class="material-icons" style="font-size:18px!important;">assignment</span>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Buat Lembar Disposisi</h3>
                    <p class="text-xs text-slate-500">Nomor: {{ $surat->nomor_surat }}</p>
                </div>
            </div>
            <button type="button" @click="showDisposisiModal = false" class="text-slate-400 hover:text-slate-600">
                <span class="material-icons">close</span>
            </button>
        </div>

        <form action="{{ route('disposisi.store', $surat->id) }}" method="POST" class="p-6 space-y-4">
            @csrf

            {{-- Pemberi Disposisi --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Pemberi Disposisi
                </label>
                <input type="text" name="pemberi_disposisi" value="{{ old('pemberi_disposisi', 'Kepala Kantor Kementerian Agama') }}" required
                    class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Tujuan Seksi --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Diteruskan Kepada Yth:
                    </label>
                    <select name="tujuan_seksi" required
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="Kasubbag Tata Usaha">Kasubbag Tata Usaha</option>
                        <option value="Seksi Pendidikan Madrasah (Penma)">Seksi Pendidikan Madrasah (Penma)</option>
                        <option value="Seksi Bimbingan Masyarakat Islam (Bimas)">Seksi Bimbingan Masyarakat Islam (Bimas)</option>
                        <option value="Seksi Penyelenggaraan Haji & Umrah (PHU)">Seksi Penyelenggaraan Haji & Umrah (PHU)</option>
                        <option value="Seksi Pendidikan Agama & Keagamaan Islam (PAKIS)">Seksi Pendidikan Agama & Keagamaan Islam (PAKIS)</option>
                        <option value="Penyelenggara Zakat dan Wakaf (Zawa)">Penyelenggara Zakat dan Wakaf (Zawa)</option>
                        <option value="Kelompok Kerja Pengawas (Pokjawas)">Kelompok Kerja Pengawas (Pokjawas)</option>
                        <option value="Staf Pelaksana / Fungsional">Staf Pelaksana / Fungsional</option>
                    </select>
                </div>

                {{-- Sifat Disposisi --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Sifat Disposisi
                    </label>
                    <select name="sifat_disposisi" required
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="Biasa">Biasa</option>
                        <option value="Segera">Segera</option>
                        <option value="Sangat Segera">Sangat Segera</option>
                        <option value="Rahasia">Rahasia</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Petunjuk Disposisi --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Petunjuk / Instruksi
                    </label>
                    <select name="petunjuk_disposisi" required
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="Tindak Lanjuti segera">Tindak Lanjuti segera</option>
                        <option value="Pelajari / Buat telaahan">Pelajari / Buat telaahan</option>
                        <option value="Siapkan bahan / konsep jawaban">Siapkan bahan / konsep jawaban</option>
                        <option value="Hadiri / Wakili pimpinan">Hadiri / Wakili pimpinan</option>
                        <option value="Koordinasikan dengan seksi terkait">Koordinasikan dengan seksi terkait</option>
                        <option value="Untuk diketahui / dipedomani">Untuk diketahui / dipedomani</option>
                        <option value="Simpan / Arsipkan">Simpan / Arsipkan</option>
                    </select>
                </div>

                {{-- Tanggal Disposisi --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal Disposisi
                    </label>
                    <input type="date" name="tanggal_disposisi" value="{{ date('Y-m-d') }}" required
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>

            {{-- Catatan Instruksi Khusus --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Catatan Instruksi Khusus (Opsional)
                </label>
                <textarea name="catatan_disposisi" rows="3" placeholder="Tuliskan pesan instruksi spesifik dari pimpinan di sini..."
                    class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" @click="showDisposisiModal = false"
                    class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2 text-sm font-bold text-white rounded-xl shadow-sm transition"
                    style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                    Simpan & Teruskan Disposisi
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ============================================================ --}}
{{-- MODAL 2: UPDATE STATUS TINDAK LANJUT                         --}}
{{-- ============================================================ --}}
<div x-show="showTindakLanjutModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4"
     x-cloak>
    
    <div @click.away="showTindakLanjutModal = false"
         class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden my-8">
        
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-cyan-50 to-white">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-cyan-600 text-white flex items-center justify-center">
                    <span class="material-icons" style="font-size:18px!important;">update</span>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Laporan Tindak Lanjut Disposisi</h3>
                    <p class="text-xs text-slate-500">Perbarui progres penyelesaian dokumen</p>
                </div>
            </div>
            <button type="button" @click="showTindakLanjutModal = false" class="text-slate-400 hover:text-slate-600">
                <span class="material-icons">close</span>
            </button>
        </div>

        <form :action="tindakLanjutUrl" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PATCH')

            {{-- Pilihan Status --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Status Progres
                </label>
                <select name="status" x-model="currentStatus" required
                    class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 font-semibold">
                    <option value="Menunggu Tindak Lanjut">⏳ Menunggu Tindak Lanjut</option>
                    <option value="Sedang Diproses">⚙️ Sedang Diproses</option>
                    <option value="Selesai">✅ Selesai</option>
                </select>
            </div>

            {{-- Catatan Hasil Tindak Lanjut --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Catatan / Laporan Hasil Tindak Lanjut
                </label>
                <textarea name="catatan_tindak_lanjut" x-model="currentCatatan" rows="4" required
                    placeholder="Tuliskan hasil tindak lanjut yang telah dilakukan oleh seksi/staf..."
                    class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" @click="showTindakLanjutModal = false"
                    class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2 text-sm font-bold text-white rounded-xl shadow-sm transition"
                    style="background:linear-gradient(135deg,#06b6d4,#0891b2);">
                    Simpan Laporan Progres
                </button>
            </div>
        </form>
    </div>
</div>

</div>

<script>
function toggleViewerFullscreenSM() {
    const elem = document.getElementById('document-viewer-box-sm');
    if (!elem) return;
    if (!document.fullscreenElement) {
        if (elem.requestFullscreen) elem.requestFullscreen();
    } else {
        if (document.exitFullscreen) document.exitFullscreen();
    }
}
</script>

@endsection

