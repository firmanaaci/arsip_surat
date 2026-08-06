@extends('components.layouts.app')

@section('content')

{{-- Toast --}}
@if (session('success'))
<div id="toast-success"
    style="position:fixed;top:24px;right:24px;z-index:9999;display:flex;align-items:center;gap:12px;padding:14px 20px;background:linear-gradient(135deg,#10b981,#059669);color:#fff;border-radius:14px;box-shadow:0 10px 40px rgba(16,185,129,0.4);font-size:14px;font-weight:600;animation:slideInRight 0.4s ease forwards;">
    <span class="material-icons" style="font-size:20px!important;">check_circle</span>
    {{ session('success') }}
</div>
<style>
    @keyframes slideInRight { from{opacity:0;transform:translateX(60px)} to{opacity:1;transform:translateX(0)} }
    @keyframes slideOutRight { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(60px)} }
</style>
<script>
    setTimeout(()=>{const t=document.getElementById('toast-success');if(t){t.style.animation='slideOutRight 0.4s ease forwards';setTimeout(()=>t.remove(),400);}},3500);
</script>
@endif

{{-- Page Header --}}
<div class="mb-6">
    <div class="flex items-center gap-2 mb-2">
        <a href="{{ route('halamanutama') }}" class="text-slate-400 hover:text-slate-600 text-sm flex items-center gap-1 transition-colors">
            <span class="material-icons" style="font-size:16px!important;">home</span>Dashboard
        </a>
        <span class="text-slate-300">/</span>
        <a href="{{ route('suratkeluar.index') }}" class="text-slate-400 hover:text-slate-600 text-sm transition-colors">Surat Keluar</a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-600 text-sm font-medium">Input Baru</span>
    </div>
    <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <span class="material-icons text-white" style="font-size:18px!important;">outbox</span>
        </div>
        Form Input Surat Keluar
    </h1>
</div>

{{-- Validation Errors --}}
@if($errors->any())
<div class="mb-5 flex items-start gap-3 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
    <span class="material-icons text-red-400 flex-shrink-0 mt-0.5" style="font-size:18px!important;">error_outline</span>
    <div>
        <p class="font-semibold mb-1">Terjadi kesalahan:</p>
        <ul class="space-y-0.5 list-disc pl-4">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
</div>
@endif

{{-- Form Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    {{-- Card Header --}}
    <div class="px-7 py-5 border-b border-slate-100 flex items-center justify-between" style="background:linear-gradient(135deg,#fffbeb,#fef9f0);">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                <span class="material-icons text-white" style="font-size:20px!important;">edit_note</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800">Data Surat Keluar</h2>
                <p class="text-xs text-slate-500">Isi semua field yang bertanda <span class="text-red-500 font-semibold">*</span></p>
            </div>
        </div>
        <a href="{{ route('suratkeluar.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors px-3 py-2 rounded-xl hover:bg-slate-100">
            <span class="material-icons" style="font-size:16px!important;">arrow_back</span>
            Kembali
        </a>
    </div>

    {{-- Form Body --}}
    <form method="POST" action="{{ route('suratkeluar.store') }}" enctype="multipart/form-data" class="p-7">
        @csrf

        {{-- Section 1: Informasi Surat --}}
        <div class="mb-8">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-5 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full text-white text-[10px] flex items-center justify-center font-bold" style="background:#f59e0b;">1</span>
                Informasi Surat
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nomor Surat --}}
                <div>
                    <label for="nomor_surat" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Nomor Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nomor_surat" id="nomor_surat" value="{{ old('nomor_surat') }}" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-amber-500/25 focus:border-amber-400 @error('nomor_surat') border-red-400 bg-red-50 @else border-slate-200 bg-white @enderror"
                        placeholder="Contoh: B-001/KMG/2026">
                    @error('nomor_surat')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
                </div>

                {{-- Tanggal Surat --}}
                <div>
                    <label for="tanggal_surat" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Tanggal Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_surat" id="tanggal_surat" value="{{ old('tanggal_surat') }}" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-amber-500/25 focus:border-amber-400 @error('tanggal_surat') border-red-400 bg-red-50 @else border-slate-200 bg-white @enderror">
                    @error('tanggal_surat')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
                </div>

                {{-- Sifat Surat --}}
                <div>
                    <label for="sifat_surat" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Sifat Surat <span class="text-red-500">*</span>
                    </label>
                    <select name="sifat_surat" id="sifat_surat" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-amber-500/25 focus:border-amber-400 @error('sifat_surat') border-red-400 bg-red-50 @else border-slate-200 bg-white @enderror">
                        <option value="">-- Pilih Sifat --</option>
                        @foreach(['Penting','Segera','Rahasia','Sangat Rahasia','Biasa'] as $sifat)
                        <option value="{{ $sifat }}" {{ old('sifat_surat')==$sifat ? 'selected':'' }}>{{ $sifat }}</option>
                        @endforeach
                    </select>
                    @error('sifat_surat')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
                </div>

                {{-- Lampiran --}}
                <div>
                    <label for="lampiran" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Lampiran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="lampiran" id="lampiran" value="{{ old('lampiran') }}" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-amber-500/25 focus:border-amber-400 @error('lampiran') border-red-400 bg-red-50 @else border-slate-200 bg-white @enderror"
                        placeholder="Contoh: 1 (satu) Berkas">
                    @error('lampiran')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
                </div>

                {{-- Hal --}}
                <div class="md:col-span-2">
                    <label for="hal" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Hal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="hal" id="hal" value="{{ old('hal') }}" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-amber-500/25 focus:border-amber-400 @error('hal') border-red-400 bg-red-50 @else border-slate-200 bg-white @enderror"
                        placeholder="Contoh: Undangan Rapat Koordinasi">
                    @error('hal')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
                </div>

                {{-- Tujuan Surat --}}
                <div class="md:col-span-2">
                    <label for="tujuan_surat" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Tujuan Surat <span class="text-red-500">*</span>
                    </label>
                    @php $tujuanList = ['Kepala kantor','Kasubbag TU','PHU','Bimas Islam','Pend. Agama & Keagamaaan Islam','Pend. Madrasah','Penyelenggara Zakat dan Wakaf','Penyelenggara Kristen','Penyelenggara Katolik','Perencana','Keuangan','Kepegawaian','Barang Milik Negara','Humas','Umum']; @endphp
                    <select name="tujuan_surat" id="tujuan_surat" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-amber-500/25 focus:border-amber-400 @error('tujuan_surat') border-red-400 bg-red-50 @else border-slate-200 bg-white @enderror">
                        <option value="">-- Pilih Tujuan --</option>
                        @foreach($tujuanList as $t)
                        <option value="{{ $t }}" {{ old('tujuan_surat')==$t ? 'selected':'' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                    @error('tujuan_surat')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-slate-100 mb-8"></div>

        {{-- Section 2: File --}}
        <div class="mb-8">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-5 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full text-white text-[10px] flex items-center justify-center font-bold" style="background:#8b5cf6;">2</span>
                Lampiran File
            </h3>
            <div>
                <label for="file" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    File Scan Surat <span class="text-red-500">*</span>
                </label>
                <div class="relative border-2 border-dashed border-slate-200 rounded-xl p-5 hover:border-amber-400 hover:bg-amber-50/20 transition-all cursor-pointer @error('file') border-red-400 @enderror">
                    <input type="file" name="file" id="file" required
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        onchange="updateFileName(this)">
                    <div class="flex items-center gap-4 pointer-events-none">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                            <span class="material-icons text-amber-400" style="font-size:24px!important;">upload_file</span>
                        </div>
                        <div>
                            <p id="file-name-display" class="text-sm font-medium text-slate-600">Klik untuk pilih file scan surat</p>
                            <p class="text-xs text-slate-400 mt-0.5">Format: PDF, JPG, PNG, DOCX · Ukuran maksimal 2MB</p>
                        </div>
                    </div>
                </div>
                @error('file')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
            <button type="reset" onclick="resetFileName()"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                <span class="material-icons" style="font-size:16px!important;">restart_alt</span>
                Reset Form
            </button>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-lg"
                style="background:linear-gradient(135deg,#f59e0b,#d97706); box-shadow:0 4px 14px rgba(245,158,11,0.4);">
                <span class="material-icons" style="font-size:16px!important;">save</span>
                Simpan Surat Keluar
            </button>
        </div>
    </form>
</div>

<script>
function updateFileName(input) {
    const display = document.getElementById('file-name-display');
    if (display && input.files && input.files[0]) {
        display.textContent = input.files[0].name;
        display.style.color = '#d97706';
    }
}
function resetFileName() {
    const display = document.getElementById('file-name-display');
    if (display) {
        display.textContent = 'Klik untuk pilih file scan surat';
        display.style.color = '';
    }
}
</script>

@endsection