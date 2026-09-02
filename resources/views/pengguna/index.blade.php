@extends('components.layouts.app')

@section('content')

<div x-data="{
    showCreateModal: false,
    showEditModal: false,
    editData: { id: null, name: '', email: '', role: 'staf' },
    openEdit(user) {
        this.editData = { id: user.id, name: user.name, email: user.email, role: user.role };
        this.showEditModal = true;
    }
}">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-slate-600 text-xs flex items-center gap-1 transition-colors">
                    <span class="material-icons" style="font-size:15px!important;">home</span>
                    Dashboard
                </a>
                <span class="text-slate-300 text-xs">/</span>
                <span class="text-slate-600 text-xs font-semibold">Manajemen Pengguna</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-800 flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
                    <span class="material-icons text-white" style="font-size:19px!important;">admin_panel_settings</span>
                </div>
                Manajemen Pengguna & Hak Akses
            </h1>
            <p class="text-xs text-slate-500 mt-1">Kelola akun staf, pimpinan kantor, dan hak akses operasional sistem.</p>
        </div>

        <button type="button" @click="showCreateModal = true"
            class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-white rounded-xl shadow-md transition-all hover:-translate-y-0.5"
            style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 14px rgba(16,185,129,0.35);">
            <span class="material-icons" style="font-size:16px!important;">person_add</span>
            + Tambah Pengguna Baru
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center flex-shrink-0">
                <span class="material-icons" style="font-size:20px!important;">people</span>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase">Total Pengguna</p>
                <p class="text-xl font-extrabold text-slate-800">{{ $stats['total'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center flex-shrink-0 border border-purple-100">
                <span class="material-icons" style="font-size:20px!important;">manage_accounts</span>
            </div>
            <div>
                <p class="text-xs text-purple-600 font-semibold uppercase">Admin / Arsiparis</p>
                <p class="text-xl font-extrabold text-slate-800">{{ $stats['admin'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0 border border-blue-100">
                <span class="material-icons" style="font-size:20px!important;">account_balance</span>
            </div>
            <div>
                <p class="text-xs text-blue-600 font-semibold uppercase">Kepala / Pimpinan</p>
                <p class="text-xl font-extrabold text-slate-800">{{ $stats['pimpinan'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center flex-shrink-0 border border-emerald-100">
                <span class="material-icons" style="font-size:20px!important;">badge</span>
            </div>
            <div>
                <p class="text-xs text-emerald-600 font-semibold uppercase">Staf Pengolah</p>
                <p class="text-xl font-extrabold text-slate-800">{{ $stats['staf'] }}</p>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm mb-6 flex flex-col sm:flex-row items-center justify-between gap-3">
        <form method="GET" action="{{ route('pengguna.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto flex-1">
            <div class="relative flex-1 sm:max-w-xs">
                <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" style="font-size:18px!important;">search</span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <select name="role" onchange="this.form.submit()"
                class="px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                <option value="">Semua Peran</option>
                <option value="admin" {{ $roleFilter === 'admin' ? 'selected' : '' }}>Admin / Arsiparis</option>
                <option value="pimpinan" {{ $roleFilter === 'pimpinan' ? 'selected' : '' }}>Pimpinan Kantor</option>
                <option value="staf" {{ $roleFilter === 'staf' ? 'selected' : '' }}>Staf Pengolah</option>
            </select>

            <button type="submit" class="px-3.5 py-2 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition">
                Filter
            </button>

            @if($search || $roleFilter)
                <a href="{{ route('pengguna.index') }}" class="text-xs text-rose-500 hover:underline">Reset</a>
            @endif
        </form>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[11px] font-bold">
                    <tr>
                        <th class="px-5 py-3.5">Pengguna</th>
                        <th class="px-5 py-3.5">Email Akun</th>
                        <th class="px-5 py-3.5">Hak Akses / Peran</th>
                        <th class="px-5 py-3.5 text-center">Riwayat Aksi</th>
                        <th class="px-5 py-3.5">Tanggal Terdaftar</th>
                        <th class="px-5 py-3.5 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $u)
                        @php
                            $roleBadge = match($u->role) {
                                'admin'    => 'bg-purple-50 text-purple-700 border-purple-200',
                                'pimpinan' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'staf'     => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                default    => 'bg-slate-100 text-slate-700 border-slate-200',
                            };
                            $roleIcon = match($u->role) {
                                'admin'    => 'manage_accounts',
                                'pimpinan' => 'account_balance',
                                'staf'     => 'badge',
                                default    => 'person',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-sm">
                                        {{ $u->initials() }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $u->name }}</p>
                                        @if($u->id === Auth::id())
                                            <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-bold bg-emerald-100 text-emerald-800">Akun Anda</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-slate-600">
                                {{ $u->email }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $roleBadge }}">
                                    <span class="material-icons" style="font-size:14px!important;">{{ $roleIcon }}</span>
                                    {{ $u->role_label }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center font-bold text-slate-600">
                                {{ $u->activity_logs_count ?? 0 }} log
                            </td>
                            <td class="px-5 py-3.5 text-slate-400">
                                {{ $u->created_at ? $u->created_at->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" @click="openEdit({{ json_encode($u) }})"
                                        class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 border border-slate-200 transition"
                                        title="Edit Pengguna">
                                        <span class="material-icons" style="font-size:15px!important;">edit</span>
                                    </button>

                                    @if($u->id !== Auth::id())
                                        <form action="{{ route('pengguna.destroy', $u->id) }}" method="POST" class="inline"
                                            data-confirm-delete="Yakin ingin menghapus akun pengguna '{{ $u->name }}'?">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 border border-slate-200 transition"
                                                title="Hapus Pengguna">
                                                <span class="material-icons" style="font-size:15px!important;">delete_outline</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-slate-400">
                                <span class="material-icons text-slate-300" style="font-size:36px!important;">person_off</span>
                                <p class="mt-1">Tidak ada data pengguna yang cocok dengan pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="px-5 py-3 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- ======================================================== --}}
    {{-- MODAL: TAMBAH PENGGUNA BARU                              --}}
    {{-- ======================================================== --}}
    <div x-show="showCreateModal" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 w-full max-w-md overflow-hidden"
            @click.away="showCreateModal = false">
            
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <span class="material-icons" style="font-size:17px!important;">person_add</span>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Tambah Pengguna Baru</h3>
                </div>
                <button type="button" @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600">
                    <span class="material-icons" style="font-size:20px!important;">close</span>
                </button>
            </div>

            <form action="{{ route('pengguna.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" name="name" required placeholder="mis. H. Ahmad Sudirman, S.Ag"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email *</label>
                    <input type="email" name="email" required placeholder="nama@gmail.com"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password Awal *</label>
                    <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Peran & Hak Akses *</label>
                    <select name="role" required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-white">
                        <option value="staf">Kepala Seksi / Staf Pengolah (Menerima Disposisi & Respon)</option>
                        <option value="pimpinan">Kepala Kantor / Pimpinan (Disposisi & Dashboard)</option>
                        <option value="admin">Arsiparis / Administrator (Akses Penuh Seluruh Sistem)</option>
                    </select>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2.5">
                    <button type="button" @click="showCreateModal = false"
                        class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- MODAL: EDIT PENGGUNA                                     --}}
    {{-- ======================================================== --}}
    <div x-show="showEditModal" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 w-full max-w-md overflow-hidden"
            @click.away="showEditModal = false">
            
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                        <span class="material-icons" style="font-size:17px!important;">edit</span>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Edit Data Pengguna</h3>
                </div>
                <button type="button" @click="showEditModal = false" class="text-slate-400 hover:text-slate-600">
                    <span class="material-icons" style="font-size:20px!important;">close</span>
                </button>
            </div>

            <form :action="'/pengguna/' + editData.id" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" name="name" required x-model="editData.name"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email *</label>
                    <input type="email" name="email" required x-model="editData.email"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password Baru (Opsional)</label>
                    <input type="password" name="password" minlength="6" placeholder="Kosongkan jika tidak ingin mengubah"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Peran & Hak Akses *</label>
                    <select name="role" required x-model="editData.role"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                        <option value="staf">Kepala Seksi / Staf Pengolah (Menerima Disposisi & Respon)</option>
                        <option value="pimpinan">Kepala Kantor / Pimpinan (Disposisi & Dashboard)</option>
                        <option value="admin">Arsiparis / Administrator (Akses Penuh Seluruh Sistem)</option>
                    </select>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2.5">
                    <button type="button" @click="showEditModal = false"
                        class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition">
                        Perbarui Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
