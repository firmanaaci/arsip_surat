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
        <span class="text-slate-600 text-sm font-medium">Edit Surat</span>
    </div>
    <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
            <span class="material-icons text-white" style="font-size:18px!important;">edit</span>
        </div>
        Edit Surat Masuk
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
    <div class="px-6 sm:px-7 py-5 border-b border-slate-100 flex items-center justify-between" style="background:linear-gradient(135deg,#eff6ff,#f0fdf4);">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                <span class="material-icons text-white" style="font-size:20px!important;">edit_note</span>
            </div>
            <div>
                <h2 class="font-bold text-slate-800">Edit Data Surat Masuk</h2>
                <p class="text-xs text-slate-500">Nomor: <span class="font-semibold text-slate-700">{{ $surat->nomor_surat }}</span></p>
            </div>
        </div>
        <a href="{{ route('suratmasuk.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors px-3 py-2 rounded-xl hover:bg-slate-100">
            <span class="material-icons" style="font-size:16px!important;">arrow_back</span>
            Kembali
        </a>
    </div>

    {{-- Form Body --}}
    <form method="POST" action="{{ route('suratmasuk.update', $surat->id) }}" enctype="multipart/form-data" class="p-5 sm:p-7">
        @csrf
        @method('PUT')

        {{-- Section 1: Informasi Dasar --}}
        <div class="mb-8">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-5 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-blue-500 text-white text-[10px] flex items-center justify-center font-bold">1</span>
                Informasi Dasar
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nomor Surat --}}
                <div>
                    <label for="nomor_surat" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Nomor Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nomor_surat" id="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat) }}" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 @error('nomor_surat') border-red-400 bg-red-50 @else border-slate-200 bg-white @enderror">
                    @error('nomor_surat')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
                </div>

                {{-- Tanggal Surat --}}
                <div>
                    <label for="tanggal_surat" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Tanggal Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_surat" id="tanggal_surat" value="{{ old('tanggal_surat', $surat->tanggal_surat) }}" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 @error('tanggal_surat') border-red-400 bg-red-50 @else border-slate-200 bg-white @enderror">
                    @error('tanggal_surat')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
                </div>

                {{-- Pengirim --}}
                <div>
                    <label for="pengirim" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Pengirim <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="pengirim" id="pengirim" value="{{ old('pengirim', $surat->pengirim) }}" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 @error('pengirim') border-red-400 bg-red-50 @else border-slate-200 bg-white @enderror">
                    @error('pengirim')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
                </div>

                {{-- Perihal --}}
                <div>
                    <label for="perihal" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Perihal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="perihal" id="perihal" value="{{ old('perihal', $surat->perihal) }}" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 @error('perihal') border-red-400 bg-red-50 @else border-slate-200 bg-white @enderror">
                    @error('perihal')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="kategori" id="kategori" value="{{ old('kategori', $surat->kategori) }}" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 @error('kategori') border-red-400 bg-red-50 @else border-slate-200 bg-white @enderror">
                    @error('kategori')<p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><span class="material-icons" style="font-size:13px!important;">error</span>{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-slate-100 mb-8"></div>

        {{-- Section 2: Klasifikasi --}}
        <div class="mb-8">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-5 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-emerald-500 text-white text-[10px] flex items-center justify-center font-bold">2</span>
                Klasifikasi & Disposisi
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Status Surat --}}
                <div>
                    <label for="status_surat" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Status Surat <span class="text-red-500">*</span>
                    </label>
                    <select name="status_surat" id="status_surat" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 border-slate-200 bg-white">
                        @foreach(['Asli', 'Tembusan'] as $status)
                            <option value="{{ $status }}" {{ old('status_surat', $surat->status_surat) == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Sifat Surat --}}
                <div>
                    <label for="sifat_surat" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Sifat Surat <span class="text-red-500">*</span>
                    </label>
                    <select name="sifat_surat" id="sifat_surat" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 border-slate-200 bg-white">
                        @foreach(['Penting', 'Segera', 'Rahasia', 'Sangat Rahasia', 'Biasa'] as $sifat)
                            <option value="{{ $sifat }}" {{ old('sifat_surat', $surat->sifat_surat) == $sifat ? 'selected' : '' }}>{{ $sifat }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tujuan Surat --}}
                <div>
                    <label for="tujuan_surat" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Tujuan Surat <span class="text-red-500">*</span>
                    </label>
                    @php $tujuanList = ['Kepala kantor', 'Kasubbag TU', 'PHU', 'Bimas Islam', 'Pend. Agama & Keagamaaan Islam', 'Pend. Madrasah', 'Penyelenggara Zakat dan Wakaf', 'Penyelenggara Kristen', 'Penyelenggara Katolik', 'Perencana', 'Keuangan', 'Kepegawaian', 'Barang Milik Negara', 'Humas', 'Umum']; @endphp
                    <select name="tujuan_surat" id="tujuan_surat" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 border-slate-200 bg-white">
                        @foreach($tujuanList as $t)
                            <option value="{{ $t }}" {{ old('tujuan_surat', $surat->tujuan_surat) == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Petunjuk --}}
                <div>
                    <label for="petunjuk" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Petunjuk <span class="text-red-500">*</span>
                    </label>
                    @php $petunjukList = ['Kepala Hadir', 'Tindak Lanjuti', 'Untuk Diketahui', 'Edarkan', 'Jawab', 'Ingatkan', 'Simpan / Arsipkan', 'Harap Hadir / Wakili']; @endphp
                    <select name="petunjuk" id="petunjuk" required
                        class="w-full px-4 py-2.5 text-sm border rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 border-slate-200 bg-white">
                        @foreach($petunjukList as $p)
                            <option value="{{ $p }}" {{ old('petunjuk', $surat->petunjuk) == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-slate-100 mb-8"></div>

        {{-- Section 3: Catatan & File --}}
        <div class="mb-8">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-5 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-violet-500 text-white text-[10px] flex items-center justify-center font-bold">3</span>
                Catatan & File
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Catatan --}}
                <div>
                    <label for="catatan" class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan</label>
                    <input type="text" name="catatan" id="catatan" value="{{ old('catatan', $surat->catatan) }}"
                        class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 bg-white">
                </div>

                {{-- Ganti File --}}
                <div>
                    <label for="file" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Ganti File (Opsional)
                    </label>
                    <div class="relative border-2 border-dashed border-slate-200 rounded-xl p-4 hover:border-blue-400 hover:bg-blue-50/30 transition-all cursor-pointer">
                        <input type="file" name="file" id="file"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            onchange="updateFileName(this)">
                        <div class="flex items-center gap-3 pointer-events-none">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <span class="material-icons text-blue-400" style="font-size:20px!important;">cloud_upload</span>
                            </div>
                            <div>
                                <p id="file-name-display" class="text-sm font-medium text-slate-600 truncate">
                                    {{ $surat->file ? 'File saat ini: ' . basename($surat->file) : 'Klik untuk ganti file' }}
                                </p>
                                <p class="text-xs text-slate-400">PDF, JPG, PNG, DOCX · Maks. 2MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Isi Disposisi --}}
                <div>
                    <label for="isi_disposisi" class="block text-sm font-semibold text-slate-700 mb-1.5">Isi Disposisi</label>
                    <textarea name="isi_disposisi" id="isi_disposisi" rows="3"
                        class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 resize-none bg-white">{{ old('isi_disposisi', $surat->isi_disposisi) }}</textarea>
                </div>

                {{-- Disposisi Kasubbag --}}
                <div>
                    <label for="disposisi_kasubbag" class="block text-sm font-semibold text-slate-700 mb-1.5">Disposisi Kasubbag</label>
                    <textarea name="disposisi_kasubbag" id="disposisi_kasubbag" rows="3"
                        class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/25 focus:border-blue-400 resize-none bg-white">{{ old('disposisi_kasubbag', $surat->disposisi_kasubbag) }}</textarea>
                </div>

            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
            <a href="{{ route('suratmasuk.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                Batal
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-lg"
                style="background:linear-gradient(135deg,#3b82f6,#2563eb); box-shadow:0 4px 14px rgba(59,130,246,0.35);">
                <span class="material-icons" style="font-size:16px!important;">save</span>
                Update Surat Masuk
            </button>
        </div>
    </form>
</div>

<script>
function updateFileName(input) {
    const display = document.getElementById('file-name-display');
    if (display && input.files && input.files[0]) {
        display.textContent = 'File baru: ' + input.files[0].name;
        display.classList.add('text-blue-600');
    }
}
</script>

@endsection
