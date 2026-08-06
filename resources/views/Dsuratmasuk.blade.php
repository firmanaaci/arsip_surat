@extends('components.layouts.app')

@section('content')

{{-- Page Header --}}
<div class="mb-6">
    <div class="flex items-center gap-2 mb-2">
        <a href="{{ route('halamanutama') }}" class="text-slate-400 hover:text-slate-600 text-sm flex items-center gap-1 transition-colors">
            <span class="material-icons" style="font-size:16px!important;">home</span>Dashboard
        </a>
        <span class="text-slate-300">/</span>
        <a href="{{ route('suratmasuk.index') }}" class="text-slate-400 hover:text-slate-600 text-sm transition-colors">Surat Masuk</a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-600 text-sm font-medium">Detail</span>
    </div>
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                <span class="material-icons text-white" style="font-size:18px!important;">move_to_inbox</span>
            </div>
            Detail Surat Masuk
        </h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('suratmasuk.edit', $surat->id) }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-amber-700 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-100 transition-all">
                <span class="material-icons" style="font-size:16px!important;">edit</span>
                Edit
            </a>
            <a href="{{ route('suratmasuk.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                <span class="material-icons" style="font-size:16px!important;">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>
</div>

{{-- Main Card --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

    {{-- Card Header --}}
    <div class="px-7 py-5 border-b border-slate-100 flex items-center justify-between" style="background:linear-gradient(135deg,#eff6ff,#f0fdf4);">
        <div class="flex items-center gap-3">
            <div>
                <p class="text-xs text-slate-500">Nomor Surat</p>
                <p class="font-bold text-slate-800 text-lg tracking-wide">{{ $surat->nomor_surat }}</p>
            </div>
        </div>
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

            {{-- Status --}}
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-cyan-50 border border-cyan-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="material-icons text-cyan-400" style="font-size:16px!important;">verified</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Status Surat</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $surat->status_surat }}</p>
                </div>
            </div>

            {{-- Tujuan --}}
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-rose-50 border border-rose-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="material-icons text-rose-400" style="font-size:16px!important;">send</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Tujuan Surat</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $surat->tujuan_surat }}</p>
                </div>
            </div>

            {{-- Petunjuk --}}
            <div class="flex items-start gap-3 sm:col-span-2 lg:col-span-1">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="material-icons text-indigo-400" style="font-size:16px!important;">assignment</span>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Petunjuk</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $surat->petunjuk }}</p>
                </div>
            </div>

        </div>

        {{-- Divider --}}
        <div class="border-t border-slate-100 my-6"></div>

        {{-- Catatan & Disposisi --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 flex items-center gap-1.5">
                    <span class="material-icons" style="font-size:14px!important;">notes</span>Catatan
                </p>
                <p class="text-sm text-slate-700 whitespace-pre-line">{{ $surat->catatan ?? '-' }}</p>
            </div>

            <div class="bg-blue-50/60 rounded-xl p-4 border border-blue-100">
                <p class="text-xs font-bold uppercase tracking-widest text-blue-400 mb-2 flex items-center gap-1.5">
                    <span class="material-icons" style="font-size:14px!important;">rate_review</span>Isi Disposisi
                </p>
                <p class="text-sm text-slate-700 whitespace-pre-line">{{ $surat->isi_disposisi ?? '-' }}</p>
            </div>

            <div class="bg-violet-50/60 rounded-xl p-4 border border-violet-100">
                <p class="text-xs font-bold uppercase tracking-widest text-violet-400 mb-2 flex items-center gap-1.5">
                    <span class="material-icons" style="font-size:14px!important;">manage_accounts</span>Disposisi Kasubbag
                </p>
                <p class="text-sm text-slate-700 whitespace-pre-line">{{ $surat->disposisi_kasubbag ?? '-' }}</p>
            </div>

        </div>

        {{-- Divider --}}
        <div class="border-t border-slate-100 my-6"></div>

        {{-- File Preview --}}
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4 flex items-center gap-2">
                <span class="material-icons" style="font-size:16px!important;">attach_file</span>
                Lampiran File Surat
            </p>

            @php
                $fileExists = $surat->file && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat->file);
            @endphp

            @if($fileExists)
                @php
                    $fileUrl = asset('storage/' . $surat->file);
                    $ext = strtolower(pathinfo($surat->file, PATHINFO_EXTENSION));
                    $isPdf = $ext === 'pdf';
                    $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                @endphp

                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <a href="{{ $fileUrl }}" target="_blank"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-lg"
                        style="background:linear-gradient(135deg,#3b82f6,#2563eb); box-shadow:0 4px 14px rgba(59,130,246,0.35);">
                        <span class="material-icons" style="font-size:16px!important;">open_in_new</span>
                        Buka File
                    </a>
                    <a href="{{ $fileUrl }}" download
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                        <span class="material-icons" style="font-size:16px!important;">download</span>
                        Download
                    </a>
                    <span class="text-xs text-slate-400 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200 uppercase font-semibold">{{ $ext }}</span>
                </div>

                {{-- Inline Preview --}}
                @if($isPdf)
                <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-50" style="height:600px;">
                    <iframe src="{{ $fileUrl }}" class="w-full h-full" frameborder="0"></iframe>
                </div>
                @elseif($isImage)
                <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-50 p-3 inline-block">
                    <img src="{{ $fileUrl }}" alt="Preview surat" class="max-w-full max-h-[500px] rounded-lg object-contain">
                </div>
                @else
                <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200 text-sm text-slate-500">
                    <span class="material-icons text-slate-400" style="font-size:20px!important;">description</span>
                    File {{ strtoupper($ext) }} — klik tombol "Buka File" atau "Download" untuk mengakses.
                </div>
                @endif

            @elseif($surat->file)
                <div class="flex items-center justify-between p-4 bg-amber-50 rounded-xl border border-amber-200 text-sm text-amber-800">
                    <div class="flex items-center gap-3">
                        <span class="material-icons text-amber-500" style="font-size:22px!important;">warning_amber</span>
                        <div>
                            <p class="font-semibold">File tidak ditemukan di server</p>
                            <p class="text-xs text-amber-600 mt-0.5">File <code class="bg-amber-100 px-1.5 py-0.5 rounded">{{ $surat->file }}</code> belum diunggah ke folder penyimpanan.</p>
                        </div>
                    </div>
                    <a href="{{ route('suratmasuk.edit', $surat->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                        <span class="material-icons" style="font-size:14px!important;">upload</span>
                        Upload File
                    </a>
                </div>
            @else
                <div class="flex items-center gap-3 p-5 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-sm text-slate-400">
                    <span class="material-icons" style="font-size:24px!important;">file_present</span>
                    <div>
                        <p class="font-medium text-slate-500">Tidak ada file terlampir</p>
                        <p class="text-xs mt-0.5">File surat belum diunggah untuk dokumen ini.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
