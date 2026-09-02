@extends('layouts.public')

@section('content')
<div class="min-h-[85vh] py-12 px-4 sm:px-6 lg:px-8 flex flex-col justify-center items-center" style="background: linear-gradient(135deg, #091a2f 0%, #0d3b2e 50%, #08201a 100%);">

    {{-- Container Card --}}
    <div class="w-full max-w-2xl bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 overflow-hidden">

        @if($isValid)
        {{-- Header Status: Valid --}}
        <div class="p-6 sm:p-8 text-center text-white relative overflow-hidden" style="background: linear-gradient(135deg, #059669 0%, #047857 50%, #064e3b 100%);">
            <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -left-8 -top-8 w-40 h-40 bg-emerald-400/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-white/20 border-2 border-white/40 flex items-center justify-center mb-3 shadow-inner">
                    <span class="material-icons text-white" style="font-size:38px!important;">verified</span>
                </div>
                <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-[11px] font-bold tracking-widest uppercase mb-1">
                    Sistem Arsip Digital Kemenag
                </span>
                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight">DOKUMEN RESMI TERVERIFIKASI</h1>
                <p class="text-emerald-100 text-xs sm:text-sm mt-1 max-w-md">
                    Dokumen ini tercatat sah dan terdaftar dalam pangkalan data arsip digital Kementerian Agama.
                </p>
            </div>
        </div>

        {{-- Verification Details Body --}}
        <div class="p-6 sm:p-8 space-y-6">

            {{-- Token Banner --}}
            <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 flex items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2 text-slate-500 truncate">
                    <span class="material-icons text-slate-400" style="font-size:16px!important;">qr_code_2</span>
                    <span class="font-mono text-[11px] truncate">UUID: {{ $surat->kode_verifikasi ?? $kode }}</span>
                </div>
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 font-bold rounded-lg text-[10px] uppercase flex-shrink-0">
                    {{ $jenis }}
                </span>
            </div>

            {{-- Letter Metadata Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Nomor Surat --}}
                <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-100 sm:col-span-2">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Nomor Surat Resmi</p>
                    <p class="text-base sm:text-lg font-bold text-slate-800 font-mono tracking-tight">{{ $surat->nomor_surat }}</p>
                </div>

                {{-- Tanggal Surat --}}
                <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-100">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Surat</p>
                    <p class="text-sm font-semibold text-slate-700">
                        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') ?? \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}
                    </p>
                </div>

                {{-- Sifat Surat --}}
                <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-100">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Sifat Dokumen</p>
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                        {{ $surat->sifat_surat ?? 'Biasa' }}
                    </span>
                </div>

                {{-- Pengirim / Asal --}}
                <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-100">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">
                        {{ $jenis == 'Surat Masuk' ? 'Pengirim (Asal)' : 'Tujuan Surat' }}
                    </p>
                    <p class="text-sm font-semibold text-slate-800">
                        {{ $jenis == 'Surat Masuk' ? $surat->pengirim : $surat->tujuan_surat }}
                    </p>
                </div>

                {{-- Tujuan / Unit --}}
                <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-100">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">
                        {{ $jenis == 'Surat Masuk' ? 'Tujuan / Diteruskan Ke' : 'Unit Pengolah' }}
                    </p>
                    <p class="text-sm font-semibold text-slate-800">
                        {{ $jenis == 'Surat Masuk' ? $surat->tujuan_surat : ($surat->kode_klasifikasi ?? 'Kantor Kementerian Agama') }}
                    </p>
                </div>

                {{-- Perihal / Hal --}}
                <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-100 sm:col-span-2">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Perihal / Isi Ringkas</p>
                    <p class="text-sm font-medium text-slate-700 leading-relaxed">
                        {{ $surat->perihal ?? $surat->hal }}
                    </p>
                </div>

                {{-- Waktu Registrasi Sistem --}}
                <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-100 sm:col-span-2">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Waktu Pengarsipan Digital</p>
                    <p class="text-xs font-mono text-slate-600 flex items-center gap-1.5">
                        <span class="material-icons text-emerald-600" style="font-size:14px!important;">schedule</span>
                        {{ $surat->created_at ? $surat->created_at->format('d M Y, H:i:s') . ' WIB' : '-' }}
                    </p>
                </div>
            </div>

            {{-- Footer Action Buttons --}}
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <a href="{{ route('home') }}" class="text-xs font-medium text-slate-500 hover:text-slate-700 flex items-center gap-1.5 transition-colors">
                    <span class="material-icons" style="font-size:16px!important;">arrow_back</span>
                    Halaman Beranda
                </a>
                <button onclick="window.print()" class="w-full sm:w-auto px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold flex items-center justify-center gap-2 shadow-sm transition-all hover:scale-105">
                    <span class="material-icons" style="font-size:16px!important;">print</span>
                    Cetak Bukti Verifikasi
                </button>
            </div>

        </div>

        @else
        {{-- Header Status: Invalid / Not Found --}}
        <div class="p-6 sm:p-8 text-center text-white relative overflow-hidden" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #991b1b 100%);">
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-white/20 border-2 border-white/40 flex items-center justify-center mb-3">
                    <span class="material-icons text-white" style="font-size:38px!important;">gpp_bad</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight">DOKUMEN TIDAK DITEMUKAN</h1>
                <p class="text-red-100 text-xs sm:text-sm mt-1 max-w-md">
                    Kode verifikasi yang dipindai tidak terdaftar atau tidak valid dalam pangkalan data arsip resmi.
                </p>
            </div>
        </div>

        <div class="p-8 text-center space-y-4">
            <div class="p-4 bg-red-50 text-red-700 rounded-2xl border border-red-200 text-xs font-mono">
                Kode/Token: {{ $kode }}
            </div>
            <p class="text-xs text-slate-500">
                Pastikan Anda memindai QR Code resmi yang tertera pada dokumen fisik atau hubungi Subbag Tata Usaha Kementerian Agama.
            </p>
            <div class="pt-4">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-800 text-white rounded-xl text-xs font-semibold hover:bg-slate-900 transition-all">
                    <span class="material-icons" style="font-size:16px!important;">home</span>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
        @endif

    </div>

</div>
@endsection
