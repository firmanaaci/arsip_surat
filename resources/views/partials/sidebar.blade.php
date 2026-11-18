@php
    $currentUser = Auth::user();
    $role = $currentUser?->role ?? 'staf';
    $trashedCount = 0;
    if ($currentUser && $currentUser->isAdmin()) {
        $trashedCount = \App\Models\SuratMasuk::onlyTrashed()->count()
                      + \App\Models\SuratKeluar::onlyTrashed()->count()
                      + \App\Models\Disposisi::onlyTrashed()->count();
    }
@endphp

<aside id="sidebar"
    class="sidebar-panel fixed lg:static inset-y-0 left-0 z-50 lg:z-30 h-full flex flex-col transition-all duration-300 overflow-hidden shrink-0 sidebar-scrollbar"
    :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full lg:translate-x-0': !sidebarOpen,
        'lg:w-20': sidebarCollapsed,
        'lg:w-72': !sidebarCollapsed,
        'w-72': true
    }"
    style="background: linear-gradient(160deg, #0f1f3d 0%, #1a3a5c 40%, #0d4a3a 100%); box-shadow: 4px 0 24px rgba(0,0,0,0.35);">

    <!-- Decorative blobs -->
    <div class="pointer-events-none absolute -top-12 -left-12 w-48 h-48 rounded-full opacity-20"
        style="background: radial-gradient(circle, #34d399, transparent); filter: blur(32px);"></div>
    <div class="pointer-events-none absolute bottom-24 -right-12 w-56 h-56 rounded-full opacity-15"
        style="background: radial-gradient(circle, #60a5fa, transparent); filter: blur(40px);"></div>

    <!-- Logo / Brand -->
    <div class="relative flex items-center pt-6 pb-5 border-b border-white/10 transition-all"
        :class="{ 'justify-center px-0': sidebarCollapsed, 'justify-between px-5': !sidebarCollapsed }">
        <div class="flex items-center gap-3 min-w-0" :class="{ 'justify-center': sidebarCollapsed }">
            <div class="shrink-0 w-11 h-11 rounded-2xl flex items-center justify-center shadow-lg"
                style="background: linear-gradient(135deg, #10b981, #059669);">
                <img src="{{ asset('logokemenag.png') }}" alt="Logo" class="w-6 h-6 object-contain">
            </div>
            <div x-show="!sidebarCollapsed" x-transition.opacity class="min-w-0">
                <h1 class="text-white font-bold text-base leading-tight tracking-wide truncate">Arsip Surat</h1>
                <p class="text-emerald-300/80 text-xs font-medium tracking-wider uppercase truncate">Kemenag</p>
            </div>
        </div>
        <!-- Mobile close button -->
        <button @click="sidebarOpen = false" class="lg:hidden text-white/60 hover:text-white p-1">
            <span class="material-icons text-[20px]">close</span>
        </button>
    </div>

    <!-- User Info Card -->
    <div class="relative transition-all mt-4 flex items-center"
        :class="{ 'justify-center px-0': sidebarCollapsed, 'px-4 py-3 mx-3 rounded-2xl border border-white/10': !sidebarCollapsed }"
        :style="!sidebarCollapsed ? 'background: rgba(255,255,255,0.06); backdrop-filter: blur(10px);' : ''">
        <div class="flex items-center gap-3 min-w-0" :class="{ 'justify-center': sidebarCollapsed }">
            <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-md border border-white/10"
                style="background: linear-gradient(135deg, #f59e0b, #d97706);"
                :title="sidebarCollapsed ? '{{ $currentUser?->name ?? 'Admin' }} ({{ $currentUser?->role_label ?? 'Staff' }})' : ''">
                {{ strtoupper(substr($currentUser?->name ?? 'A', 0, 1)) }}
            </div>
            <div class="min-w-0" x-show="!sidebarCollapsed" x-transition.opacity>
                <p class="text-white text-xs font-semibold truncate">{{ $currentUser?->name ?? 'Pengguna' }}</p>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full {{ $role === 'admin' ? 'bg-purple-400' : ($role === 'pimpinan' ? 'bg-blue-400' : 'bg-emerald-400') }}"></span>
                    <p class="text-emerald-300/80 text-[10px] font-medium tracking-wide truncate uppercase">
                        {{ $currentUser?->role_label ?? 'Staff' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto sidebar-scrollbar">

        <p x-show="!sidebarCollapsed" x-transition.opacity class="text-[10px] font-bold uppercase tracking-widest text-white/30 px-3 mb-2">Menu Utama</p>

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center rounded-2xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('dashboard') || request()->routeIs('halamanutama') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :class="{ 'justify-center w-11 h-11 mx-auto px-0': sidebarCollapsed, 'px-3.5 py-2.5 gap-3': !sidebarCollapsed }"
            :title="sidebarCollapsed ? 'Dashboard' : ''">
            @if(request()->routeIs('dashboard') || request()->routeIs('halamanutama'))
                <div class="absolute inset-0 rounded-2xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.95;"></div>
            @else
                <div class="absolute inset-0 rounded-2xl bg-white/0 group-hover:bg-white/10 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[21px] shrink-0 {{ request()->routeIs('dashboard') || request()->routeIs('halamanutama') ? 'text-white' : 'text-emerald-400/80 group-hover:text-emerald-300' }}">dashboard</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Dashboard</span>
        </a>

        {{-- Input Surat Masuk (Khusus Admin / Arsiparis) --}}
        @if($currentUser?->isAdmin())
        <a href="{{ route('inputsuratmasuk') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center rounded-2xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('inputsuratmasuk') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :class="{ 'justify-center w-11 h-11 mx-auto px-0': sidebarCollapsed, 'px-3.5 py-2.5 gap-3': !sidebarCollapsed }"
            :title="sidebarCollapsed ? 'Input Surat Masuk' : ''">
            @if(request()->routeIs('inputsuratmasuk'))
                <div class="absolute inset-0 rounded-2xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.95;"></div>
            @else
                <div class="absolute inset-0 rounded-2xl bg-white/0 group-hover:bg-white/10 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[21px] shrink-0 {{ request()->routeIs('inputsuratmasuk') ? 'text-white' : 'text-blue-400/80 group-hover:text-blue-300' }}">move_to_inbox</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Input Surat Masuk</span>
        </a>

        {{-- Input Surat Keluar (Khusus Admin / Arsiparis) --}}
        <a href="{{ route('inputsuratkeluar') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center rounded-2xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('inputsuratkeluar') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :class="{ 'justify-center w-11 h-11 mx-auto px-0': sidebarCollapsed, 'px-3.5 py-2.5 gap-3': !sidebarCollapsed }"
            :title="sidebarCollapsed ? 'Input Surat Keluar' : ''">
            @if(request()->routeIs('inputsuratkeluar'))
                <div class="absolute inset-0 rounded-2xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.95;"></div>
            @else
                <div class="absolute inset-0 rounded-2xl bg-white/0 group-hover:bg-white/10 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[21px] shrink-0 {{ request()->routeIs('inputsuratkeluar') ? 'text-white' : 'text-amber-400/80 group-hover:text-amber-300' }}">outbox</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Input Surat Keluar</span>
        </a>
        @endif

        {{-- Tabel Surat Masuk --}}
        <a href="{{ route('suratmasuk.index') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center rounded-2xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('suratmasuk.index') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :class="{ 'justify-center w-11 h-11 mx-auto px-0': sidebarCollapsed, 'px-3.5 py-2.5 gap-3': !sidebarCollapsed }"
            :title="sidebarCollapsed ? 'Tabel Surat Masuk' : ''">
            @if(request()->routeIs('suratmasuk.index'))
                <div class="absolute inset-0 rounded-2xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.95;"></div>
            @else
                <div class="absolute inset-0 rounded-2xl bg-white/0 group-hover:bg-white/10 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[21px] shrink-0 {{ request()->routeIs('suratmasuk.index') ? 'text-white' : 'text-cyan-400/80 group-hover:text-cyan-300' }}">inbox</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Tabel Surat Masuk</span>
        </a>

        {{-- Tabel Surat Keluar --}}
        <a href="{{ route('suratkeluar.index') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center rounded-2xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('suratkeluar.index') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :class="{ 'justify-center w-11 h-11 mx-auto px-0': sidebarCollapsed, 'px-3.5 py-2.5 gap-3': !sidebarCollapsed }"
            :title="sidebarCollapsed ? 'Tabel Surat Keluar' : ''">
            @if(request()->routeIs('suratkeluar.index'))
                <div class="absolute inset-0 rounded-2xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.95;"></div>
            @else
                <div class="absolute inset-0 rounded-2xl bg-white/0 group-hover:bg-white/10 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[21px] shrink-0 {{ request()->routeIs('suratkeluar.index') ? 'text-white' : 'text-rose-400/80 group-hover:text-rose-300' }}">send</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Tabel Surat Keluar</span>
        </a>

        {{-- Section Divider Laporan --}}
        <div class="pt-3 pb-1">
            <p x-show="!sidebarCollapsed" x-transition.opacity class="text-[10px] font-bold uppercase tracking-widest text-white/30 px-3 mb-2">Laporan</p>
            <div x-show="sidebarCollapsed" class="w-8 h-px bg-white/10 mx-auto my-1"></div>
        </div>

        {{-- Laporan & Export --}}
        <a href="{{ route('laporan.index') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center rounded-2xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->is('laporan*') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :class="{ 'justify-center w-11 h-11 mx-auto px-0': sidebarCollapsed, 'px-3.5 py-2.5 gap-3': !sidebarCollapsed }"
            :title="sidebarCollapsed ? 'Laporan & Export' : ''">
            @if(request()->is('laporan*'))
                <div class="absolute inset-0 rounded-2xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.95;"></div>
            @else
                <div class="absolute inset-0 rounded-2xl bg-white/0 group-hover:bg-white/10 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[21px] shrink-0 {{ request()->is('laporan*') ? 'text-white' : 'text-violet-400/80 group-hover:text-violet-300' }}">assessment</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Laporan & Export</span>
        </a>

        {{-- Section Divider Keamanan & Tata Kelola --}}
        @if($currentUser?->hasRole(['admin', 'pimpinan']))
        <div class="pt-3 pb-1">
            <p x-show="!sidebarCollapsed" x-transition.opacity class="text-[10px] font-bold uppercase tracking-widest text-white/30 px-3 mb-2">Tata Kelola & Audit</p>
            <div x-show="sidebarCollapsed" class="w-8 h-px bg-white/10 mx-auto my-1"></div>
        </div>

        {{-- Audit Trail / Log Aktivitas --}}
        <a href="{{ route('audit.index') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center rounded-2xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('audit.index') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :class="{ 'justify-center w-11 h-11 mx-auto px-0': sidebarCollapsed, 'px-3.5 py-2.5 gap-3': !sidebarCollapsed }"
            :title="sidebarCollapsed ? 'Log Aktivitas (Audit Trail)' : ''">
            @if(request()->routeIs('audit.index'))
                <div class="absolute inset-0 rounded-2xl" style="background: linear-gradient(135deg, #0ea5e9, #0284c7); opacity: 0.95;"></div>
            @else
                <div class="absolute inset-0 rounded-2xl bg-white/0 group-hover:bg-white/10 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[21px] shrink-0 {{ request()->routeIs('audit.index') ? 'text-white' : 'text-sky-400/80 group-hover:text-sky-300' }}">history</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Log Aktivitas (Audit)</span>
        </a>
        @endif

        @if($currentUser?->isAdmin())
        {{-- Tempat Sampah (Recycle Bin) --}}
        <a href="{{ route('recyclebin.index') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center rounded-2xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('recyclebin.index') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :class="{ 'justify-center w-11 h-11 mx-auto px-0': sidebarCollapsed, 'justify-between px-3.5 py-2.5': !sidebarCollapsed }"
            :title="sidebarCollapsed ? 'Tempat Sampah{{ $trashedCount > 0 ? ' (' . $trashedCount . ' data)' : '' }}' : ''">
            @if(request()->routeIs('recyclebin.index'))
                <div class="absolute inset-0 rounded-2xl" style="background: linear-gradient(135deg, #ef4444, #dc2626); opacity: 0.95;"></div>
            @else
                <div class="absolute inset-0 rounded-2xl bg-white/0 group-hover:bg-white/10 transition-colors duration-200"></div>
            @endif
            <div class="flex items-center min-w-0 relative" :class="{ 'justify-center': sidebarCollapsed, 'gap-3': !sidebarCollapsed }">
                <span class="material-icons text-[21px] shrink-0 {{ request()->routeIs('recyclebin.index') ? 'text-white' : 'text-rose-400/80 group-hover:text-rose-300' }}">delete_sweep</span>
                <span class="truncate" x-show="!sidebarCollapsed" x-transition.opacity>Tempat Sampah</span>
            </div>
            @if($trashedCount > 0)
                <span x-show="!sidebarCollapsed" x-transition.opacity
                    class="relative px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-rose-500/30 text-rose-200 border border-rose-400/40">
                    {{ $trashedCount }}
                </span>
            @endif
        </a>

        {{-- Manajemen Pengguna --}}
        <a href="{{ route('pengguna.index') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center rounded-2xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('pengguna.index') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :class="{ 'justify-center w-11 h-11 mx-auto px-0': sidebarCollapsed, 'px-3.5 py-2.5 gap-3': !sidebarCollapsed }"
            :title="sidebarCollapsed ? 'Manajemen Pengguna' : ''">
            @if(request()->routeIs('pengguna.index'))
                <div class="absolute inset-0 rounded-2xl" style="background: linear-gradient(135deg, #6366f1, #4f46e5); opacity: 0.95;"></div>
            @else
                <div class="absolute inset-0 rounded-2xl bg-white/0 group-hover:bg-white/10 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[21px] shrink-0 {{ request()->routeIs('pengguna.index') ? 'text-white' : 'text-indigo-400/80 group-hover:text-indigo-300' }}">admin_panel_settings</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Kelola Pengguna</span>
        </a>
        @endif

    </nav>

    {{-- <!-- Footer Logout -->
    <div class="relative py-4 border-t border-white/10"
        :class="{ 'px-0 flex justify-center': sidebarCollapsed, 'px-4': !sidebarCollapsed }">
        <form method="POST" action="{{ route('logout') }}" :class="{ 'w-auto': sidebarCollapsed, 'w-full': !sidebarCollapsed }">
            @csrf
            <button type="submit"
                class="flex items-center rounded-2xl text-sm font-medium text-red-400/90 hover:text-red-300 hover:bg-red-500/15 transition-all group"
                :class="{ 'justify-center w-11 h-11 mx-auto px-0': sidebarCollapsed, 'w-full px-3.5 py-2.5 gap-3': !sidebarCollapsed }"
                :title="sidebarCollapsed ? 'Keluar dari Akun' : ''">
                <span class="material-icons text-[21px] shrink-0 group-hover:scale-110 transition-transform">logout</span>
                <span class="truncate" x-show="!sidebarCollapsed" x-transition.opacity>Keluar</span>
            </button>
        </form>
        <p x-show="!sidebarCollapsed" x-transition.opacity class="text-white/20 text-[10px] text-center mt-2 tracking-wider">v1.0 © {{ date('Y') }} Kemenag</p>
    </div> --}}
</aside>
