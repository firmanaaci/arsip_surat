@extends('components.layouts.app')

@section('content')

{{-- ========================================================= --}}
{{-- BREADCRUMB & PAGE HEADER                                   --}}
{{-- ========================================================= --}}
<div class="mb-6">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-xs text-slate-400 mb-4" aria-label="breadcrumb">
        <a href="{{ route('halamanutama') }}" class="hover:text-amber-600 flex items-center gap-1 transition-colors font-medium">
            <span class="material-icons" style="font-size:13px!important;">home</span>
            Dashboard
        </a>
        <span class="material-icons" style="font-size:12px!important;">chevron_right</span>
        <a href="{{ route('suratkeluar.index') }}" class="hover:text-amber-600 transition-colors font-medium">Surat Keluar</a>
        <span class="material-icons" style="font-size:12px!important;">chevron_right</span>
        <span class="text-slate-600 font-semibold">Detail Surat</span>
    </nav>

    {{-- Page Title + Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center shadow-md flex-shrink-0"
                 style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <span class="material-icons text-white" style="font-size:20px!important;">outbox</span>
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-800 leading-tight">Detail Surat Keluar</h1>
                <p class="text-xs text-slate-400 mt-0.5">Informasi lengkap & verifikasi dokumen</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            
            <a href="{{ route('suratkeluar.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all">
                <span class="material-icons" style="font-size:15px!important;">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>
</div>

{{-- ========================================================= --}}
{{-- MAIN LAYOUT: Two-Column Grid                               --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- ===================================================== --}}
    {{-- LEFT COLUMN: Primary Info (spans 2/3 on xl)           --}}
    {{-- ===================================================== --}}
    <div class="xl:col-span-2 flex flex-col gap-6">

        {{-- --- IDENTITY CARD --- --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- Header strip --}}
            <div class="px-6 py-4 flex items-center justify-between"
                 style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 60%, #fff7ed 100%); border-bottom: 1px solid #fde68a;">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-amber-600/80 mb-0.5">Nomor Surat</p>
                    <p class="text-xl font-bold text-slate-800 tracking-wide">{{ $surat->nomor_surat }}</p>
                </div>
                @php
                    $sifat = $surat->sifat_surat;
                    $sifatConfig = match($sifat) {
                        'Rahasia','Sangat Rahasia' => ['bg-red-100 text-red-700 border-red-200', 'lock'],
                        'Penting','Segera'         => ['bg-orange-100 text-orange-700 border-orange-200', 'priority_high'],
                        default                    => ['bg-slate-100 text-slate-600 border-slate-200', 'info'],
                    };
                @endphp
                <div class="flex flex-col items-end gap-1.5">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-xl border {{ $sifatConfig[0] }}">
                        <span class="material-icons" style="font-size:13px!important;">{{ $sifatConfig[1] }}</span>
                        {{ $sifat }}
                    </span>
                    @if($surat->kode_klasifikasi)
                    <span class="inline-block px-2.5 py-0.5 rounded-lg text-[10px] font-mono font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                        Klasifikasi: {{ $surat->kode_klasifikasi }}
                    </span>
                    @endif
                </div>
            </div>

            {{-- Detail Grid --}}
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">

                    {{-- Tanggal Surat --}}
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center flex-shrink-0">
                            <span class="material-icons text-amber-500" style="font-size:17px!important;">calendar_today</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Tanggal Surat</p>
                            <p class="text-sm font-semibold text-slate-800">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->isoFormat('D MMMM Y') }}</p>
                        </div>
                    </div>

                    {{-- Lampiran --}}
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-shrink-0">
                            <span class="material-icons text-blue-500" style="font-size:17px!important;">attach_file</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Lampiran</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $surat->lampiran ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Hal / Perihal --}}
                    <div class="flex items-start gap-3 sm:col-span-2">
                        <div class="w-9 h-9 rounded-xl bg-violet-50 border border-violet-100 flex items-center justify-center flex-shrink-0">
                            <span class="material-icons text-violet-500" style="font-size:17px!important;">subject</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Perihal / Hal</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $surat->hal }}</p>
                        </div>
                    </div>

                    {{-- Tujuan Surat --}}
                    <div class="flex items-start gap-3 sm:col-span-2">
                        <div class="w-9 h-9 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center flex-shrink-0">
                            <span class="material-icons text-rose-500" style="font-size:17px!important;">send</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Ditujukan Kepada</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $surat->tujuan_surat }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- --- FILE ATTACHMENT SECTION --- --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- Section Header --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center">
                    <span class="material-icons text-amber-500" style="font-size:16px!important;">folder_open</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-700">Lampiran Berkas</p>
                    <p class="text-[10px] text-slate-400">Pratinjau & integritas dokumen digital</p>
                </div>
            </div>

            <div class="p-6">
                @php
                    $fileExists = $surat->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat->file_path);
                @endphp

                @if($fileExists)
                    @php
                        $fileUrl  = asset('storage/' . $surat->file_path);
                        $ext      = strtolower(pathinfo($surat->file_path, PATHINFO_EXTENSION));
                        $isPdf    = $ext === 'pdf';
                        $isImage  = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                        $isWord   = in_array($ext, ['doc','docx']);
                        $isExcel  = in_array($ext, ['xls','xlsx','csv']);
                        $canPreview = $isPdf || $isImage;
                    @endphp

                    {{-- File Integrity Fingerprint Bar --}}
                    <div class="mb-5 rounded-xl bg-slate-50 border border-slate-200/80 overflow-hidden">
                        <div class="px-4 py-2.5 border-b border-slate-200/80">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Integritas & Metadata Teknis</p>
                        </div>
                        <div class="p-4 flex flex-col gap-3 text-xs">
                            {{-- Row 1: Size + Type (side by side) --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div class="flex items-center gap-2">
                                    <span class="material-icons text-slate-400 flex-shrink-0" style="font-size:15px!important;">sd_card</span>
                                    <div class="min-w-0">
                                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Ukuran Berkas</span>
                                        <span class="font-bold text-slate-700">{{ $fileInfo['size'] ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-icons text-slate-400 flex-shrink-0" style="font-size:15px!important;">description</span>
                                    <div class="min-w-0">
                                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Format</span>
                                        <span class="font-bold text-slate-700 uppercase">{{ $ext }}</span>
                                        <span class="block text-slate-500 text-[10px] truncate" title="{{ $fileInfo['mime'] ?? '' }}">{{ $fileInfo['mime'] ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            {{-- Row 2: SHA-256 full width --}}
                            <div class="border-t border-slate-200/80 pt-3 flex items-start gap-2">
                                <span class="material-icons text-slate-400 flex-shrink-0 mt-0.5" style="font-size:15px!important;">fingerprint</span>
                                <div class="min-w-0 flex-1">
                                    <span class="text-slate-400 block text-[10px] uppercase font-semibold mb-0.5">SHA-256 Checksum</span>
                                    <span class="font-mono text-[10px] text-slate-600 break-all leading-relaxed">{{ $fileInfo['hash'] ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($canPreview)
                        {{-- Toolbar for previewable files --}}
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ $fileUrl }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-md"
                                    style="background:linear-gradient(135deg,#f59e0b,#d97706); box-shadow:0 3px 10px rgba(245,158,11,0.3);">
                                    <span class="material-icons" style="font-size:14px!important;">open_in_new</span>
                                    Buka Tab Baru
                                </a>
                                <a href="{{ $fileUrl }}" download
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                                    <span class="material-icons" style="font-size:14px!important;">download</span>
                                    Download
                                </a>
                            </div>
                            <button type="button" onclick="toggleViewerFullscreen()"
                                class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                                <span class="material-icons" style="font-size:14px!important;">fullscreen</span>
                                Layar Penuh
                            </button>
                        </div>

                        {{-- Preview Container --}}
                        <div id="document-viewer-box" class="rounded-xl overflow-hidden border border-slate-200 transition-all duration-300">
                            @if($isPdf)
                            <div class="flex items-center justify-between px-4 py-2.5 bg-slate-800 border-b border-slate-700">
                                <span class="flex items-center gap-2 text-xs font-medium text-white">
                                    <span class="material-icons text-amber-400" style="font-size:15px!important;">picture_as_pdf</span>
                                    Pratinjau PDF
                                </span>
                                <span class="text-[11px] font-mono text-slate-400 truncate max-w-[200px]">{{ basename($surat->file_path) }}</span>
                            </div>
                            <div style="height: 640px;">
                                <iframe src="{{ $fileUrl }}#toolbar=1&navpanes=0" class="w-full h-full border-0"></iframe>
                            </div>
                            @elseif($isImage)
                            <div class="p-6 bg-slate-900/95 flex items-center justify-center" style="min-height: 420px;">
                                <img src="{{ $fileUrl }}" alt="Scan surat" class="max-w-full max-h-[600px] rounded-xl object-contain shadow-2xl">
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
                                        <p class="text-sm font-bold text-slate-800 truncate">{{ basename($surat->file_path) }}</p>
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
                                        <p class="text-sm font-bold text-slate-800 truncate">{{ basename($surat->file_path) }}</p>
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
                                        <p class="text-sm font-bold text-slate-800 truncate">{{ basename($surat->file_path) }}</p>
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

                @elseif($surat->file_path)
                    {{-- File path exists but file missing --}}
                    <div class="flex items-center justify-between gap-4 p-4 bg-amber-50 rounded-xl border border-amber-200">
                        <div class="flex items-center gap-3">
                            <span class="material-icons text-amber-500" style="font-size:22px!important;">warning_amber</span>
                            <div>
                                <p class="text-sm font-bold text-amber-800">File tidak ditemukan di server</p>
                                <p class="text-xs text-amber-600 mt-0.5">
                                    <code class="bg-amber-100 px-1.5 py-0.5 rounded text-amber-700">{{ $surat->file_path }}</code>
                                    belum diunggah.
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('suratkeluar.edit', $surat->id) }}"
                           class="flex-shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold bg-amber-600 text-white rounded-xl hover:bg-amber-700 transition-all">
                            <span class="material-icons" style="font-size:14px!important;">upload</span>
                            Upload
                        </a>
                    </div>
                @else
                    {{-- No file --}}
                    <div class="flex flex-col items-center justify-center py-10 px-4 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
                            <span class="material-icons text-slate-400" style="font-size:24px!important;">file_present</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-500">Tidak ada file terlampir</p>
                        <p class="text-xs text-slate-400 mt-1">File surat belum diunggah untuk dokumen ini.</p>
                        <a href="{{ route('suratkeluar.edit', $surat->id) }}"
                           class="mt-3 inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-white rounded-xl transition-all hover:opacity-90"
                           style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                            <span class="material-icons" style="font-size:14px!important;">upload</span>
                            Upload Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>{{-- end LEFT column --}}

    {{-- ===================================================== --}}
    {{-- RIGHT COLUMN: QR Verification + Quick Actions          --}}
    {{-- ===================================================== --}}
    <div class="flex flex-col gap-6">

        {{-- --- QR VERIFICATION CARD --- --}}
        @php
            $verifyUrl = \App\Services\QrCodeService::getVerificationUrl($surat->kode_verifikasi ?? $surat->nomor_surat);
            $qrSvgUrl  = \App\Services\QrCodeService::generateSvg($verifyUrl, 140);
        @endphp
        <div class="bg-white rounded-2xl border border-emerald-200 shadow-sm overflow-hidden">
            {{-- Header --}}
            <div class="px-5 py-4 border-b border-emerald-100" style="background: linear-gradient(135deg, #f0fdf4, #ecfdf5);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-600 flex items-center justify-center">
                        <span class="material-icons text-white" style="font-size:15px!important;">verified</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-emerald-800">Verifikasi Keaslian</p>
                        <p class="text-[10px] text-emerald-600">Arsip Digital Kementerian Agama</p>
                    </div>
                </div>
            </div>

            {{-- QR Code --}}
            <div class="p-5 flex flex-col items-center text-center">
                <div class="w-36 h-36 bg-white p-2.5 rounded-2xl border-2 border-emerald-200 shadow-md flex items-center justify-center mb-4">
                    <img src="{{ $qrSvgUrl }}" alt="QR Code Verifikasi" class="w-full h-full object-contain">
                </div>
                <p class="text-xs font-semibold text-slate-700 mb-1">Pindai untuk verifikasi dokumen</p>
                <p class="text-[11px] text-slate-400 leading-relaxed mb-4">
                    Gunakan kamera ponsel atau Google Lens untuk membuka portal verifikasi resmi Kemenag.
                </p>

                {{-- UUID Badge --}}
                @if($surat->kode_verifikasi)
                <div class="w-full p-2.5 bg-slate-50 rounded-xl border border-slate-200 mb-4">
                    <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1">UUID Verifikasi</p>
                    <p class="font-mono text-[10px] text-slate-600 break-all leading-relaxed">{{ $surat->kode_verifikasi }}</p>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex flex-col gap-2 w-full">
                    <a href="{{ $verifyUrl }}" target="_blank"
                        class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 text-xs font-bold text-white rounded-xl transition-all hover:scale-[1.02]"
                        style="background: linear-gradient(135deg, #059669, #047857); box-shadow: 0 4px 12px rgba(5,150,105,0.35);">
                        <span class="material-icons" style="font-size:15px!important;">open_in_new</span>
                        Buka Halaman Verifikasi
                    </a>
                    <button type="button"
                        onclick="navigator.clipboard.writeText('{{ $verifyUrl }}').then(() => { this.textContent = '✓ Tersalin!'; setTimeout(() => this.innerHTML = '<span class=\'material-icons\' style=\'font-size:14px!important;\'>content_copy</span> Salin URL Verifikasi', 2000) })"
                        class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                        <span class="material-icons" style="font-size:14px!important;">content_copy</span>
                        Salin URL Verifikasi
                    </button>
                </div>
            </div>
        </div>

        {{-- --- QUICK ACTIONS CARD --- --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Aksi Cepat</p>
            </div>
            <div class="p-4 flex flex-col gap-2">
                <a href="{{ route('suratkeluar.edit', $surat->id) }}"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-amber-50 hover:border-amber-200 border border-transparent transition-all group">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-200 transition-colors">
                        <span class="material-icons" style="font-size:16px!important;">edit</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-700">Edit Surat</p>
                        <p class="text-[10px] text-slate-400">Ubah data & informasi surat</p>
                    </div>
                </a>

                @if(isset($fileUrl))
                <a href="{{ $fileUrl }}" download
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 hover:border-blue-200 border border-transparent transition-all group">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-200 transition-colors">
                        <span class="material-icons" style="font-size:16px!important;">download</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-700">Download Berkas</p>
                        <p class="text-[10px] text-slate-400">Unduh file dokumen asli</p>
                    </div>
                </a>
                @endif

                <a href="{{ $verifyUrl }}" target="_blank"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-emerald-50 hover:border-emerald-200 border border-transparent transition-all group">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-200 transition-colors">
                        <span class="material-icons" style="font-size:16px!important;">qr_code_scanner</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-700">Portal Verifikasi</p>
                        <p class="text-[10px] text-slate-400">Validasi keaslian dokumen</p>
                    </div>
                </a>

                <form action="{{ route('suratkeluar.destroy', $surat->id) }}" method="POST"
                      data-confirm-delete="Yakin ingin menghapus surat keluar '{{ $surat->nomor_surat }}'? Tindakan ini tidak dapat dibatalkan.">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-red-50 hover:border-red-200 border border-transparent transition-all group text-left">
                        <div class="w-8 h-8 rounded-lg bg-red-100 text-red-500 flex items-center justify-center flex-shrink-0 group-hover:bg-red-200 transition-colors">
                            <span class="material-icons" style="font-size:16px!important;">delete_outline</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-red-600">Hapus Surat</p>
                            <p class="text-[10px] text-slate-400">Hapus permanen dari sistem</p>
                        </div>
                    </button>
                </form>
            </div>
        </div>

        {{-- --- RECORD META CARD --- --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Informasi Rekaman</p>
            </div>
            <div class="p-5 flex flex-col gap-3 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-slate-400 font-medium">ID Dokumen</span>
                    <span class="font-mono font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded-lg">#{{ str_pad($surat->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="border-t border-slate-100"></div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400 font-medium">Dibuat</span>
                    <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($surat->created_at)->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
                @if($surat->updated_at && $surat->updated_at != $surat->created_at)
                <div class="flex items-center justify-between">
                    <span class="text-slate-400 font-medium">Diperbarui</span>
                    <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($surat->updated_at)->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
                @endif
            </div>
        </div>

    </div>{{-- end RIGHT column --}}

</div>{{-- end grid --}}

<script>
function toggleViewerFullscreen() {
    const elem = document.getElementById('document-viewer-box');
    if (!elem) return;
    if (!document.fullscreenElement) {
        elem.requestFullscreen?.();
    } else {
        document.exitFullscreen?.();
    }
}
</script>

@endsection
