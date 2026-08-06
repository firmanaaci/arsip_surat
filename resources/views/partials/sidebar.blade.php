<aside id="sidebar"
    class="sidebar-panel fixed lg:relative inset-y-0 left-0 z-50 flex flex-col transition-all duration-300 overflow-hidden flex-shrink-0 sidebar-scrollbar"
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
    <div class="relative flex items-center justify-between px-5 pt-6 pb-5 border-b border-white/10">
        <div class="flex items-center gap-3 min-w-0">
            <div class="flex-shrink-0 w-10 h-10 rounded-2xl flex items-center justify-center shadow-lg"
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
    <div class="relative px-4 py-3 mx-3 mt-4 rounded-2xl border border-white/10 transition-all"
        style="background: rgba(255,255,255,0.06); backdrop-filter: blur(10px);">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0"
                style="background: linear-gradient(135deg, #f59e0b, #d97706);"
                :title="sidebarCollapsed ? '{{ Auth::user()->name }}' : ''">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0" x-show="!sidebarCollapsed" x-transition.opacity>
                <p class="text-white text-xs font-semibold truncate">{{ Auth::user()->name }}</p>
                <p class="text-emerald-300/70 text-[10px] truncate">{{ Auth::user()->role ?? 'Staff' }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto sidebar-scrollbar">

        <p x-show="!sidebarCollapsed" x-transition.opacity class="text-[10px] font-bold uppercase tracking-widest text-white/30 px-3 mb-2">Menu Utama</p>

        {{-- Dashboard --}}
        <a href="{{ route('halamanutama') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('halamanutama') || request()->routeIs('dashboard') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :title="sidebarCollapsed ? 'Dashboard' : ''">
            @if(request()->routeIs('halamanutama') || request()->routeIs('dashboard'))
                <div class="absolute inset-0 rounded-xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.9;"></div>
            @else
                <div class="absolute inset-0 rounded-xl bg-white/0 group-hover:bg-white/5 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[20px] flex-shrink-0 {{ request()->routeIs('halamanutama') || request()->routeIs('dashboard') ? 'text-white' : 'text-emerald-400/70 group-hover:text-emerald-300' }}">dashboard</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Dashboard</span>
        </a>

        {{-- Input Surat Masuk --}}
        <a href="{{ route('inputsuratmasuk') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('inputsuratmasuk') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :title="sidebarCollapsed ? 'Input Surat Masuk' : ''">
            @if(request()->routeIs('inputsuratmasuk'))
                <div class="absolute inset-0 rounded-xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.9;"></div>
            @else
                <div class="absolute inset-0 rounded-xl bg-white/0 group-hover:bg-white/5 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[20px] flex-shrink-0 {{ request()->routeIs('inputsuratmasuk') ? 'text-white' : 'text-blue-400/70 group-hover:text-blue-300' }}">move_to_inbox</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Input Surat Masuk</span>
        </a>

        {{-- Input Surat Keluar --}}
        <a href="{{ route('inputsuratkeluar') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('inputsuratkeluar') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :title="sidebarCollapsed ? 'Input Surat Keluar' : ''">
            @if(request()->routeIs('inputsuratkeluar'))
                <div class="absolute inset-0 rounded-xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.9;"></div>
            @else
                <div class="absolute inset-0 rounded-xl bg-white/0 group-hover:bg-white/5 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[20px] flex-shrink-0 {{ request()->routeIs('inputsuratkeluar') ? 'text-white' : 'text-amber-400/70 group-hover:text-amber-300' }}">outbox</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Input Surat Keluar</span>
        </a>

        {{-- Tabel Surat Masuk --}}
        <a href="{{ route('suratmasuk.index') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('suratmasuk.index') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :title="sidebarCollapsed ? 'Tabel Surat Masuk' : ''">
            @if(request()->routeIs('suratmasuk.index'))
                <div class="absolute inset-0 rounded-xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.9;"></div>
            @else
                <div class="absolute inset-0 rounded-xl bg-white/0 group-hover:bg-white/5 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[20px] flex-shrink-0 {{ request()->routeIs('suratmasuk.index') ? 'text-white' : 'text-cyan-400/70 group-hover:text-cyan-300' }}">inbox</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Tabel Surat Masuk</span>
        </a>

        {{-- Tabel Surat Keluar --}}
        <a href="{{ route('suratkeluar.index') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->routeIs('suratkeluar.index') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :title="sidebarCollapsed ? 'Tabel Surat Keluar' : ''">
            @if(request()->routeIs('suratkeluar.index'))
                <div class="absolute inset-0 rounded-xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.9;"></div>
            @else
                <div class="absolute inset-0 rounded-xl bg-white/0 group-hover:bg-white/5 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[20px] flex-shrink-0 {{ request()->routeIs('suratkeluar.index') ? 'text-white' : 'text-rose-400/70 group-hover:text-rose-300' }}">send</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Tabel Surat Keluar</span>
        </a>

        <div class="pt-3 pb-1">
            <p x-show="!sidebarCollapsed" x-transition.opacity class="text-[10px] font-bold uppercase tracking-widest text-white/30 px-3 mb-2">Laporan</p>
        </div>

        {{-- Laporan --}}
        <a href="{{ route('laporan.index') }}"
            @click="sidebarOpen = false"
            class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                {{ request()->is('laporan') ? 'sidebar-link-active' : 'text-slate-300 hover:text-white' }}"
            :title="sidebarCollapsed ? 'Laporan & Export' : ''">
            @if(request()->is('laporan'))
                <div class="absolute inset-0 rounded-xl" style="background: linear-gradient(135deg, #10b981, #059669); opacity: 0.9;"></div>
            @else
                <div class="absolute inset-0 rounded-xl bg-white/0 group-hover:bg-white/5 transition-colors duration-200"></div>
            @endif
            <span class="material-icons relative text-[20px] flex-shrink-0 {{ request()->is('laporan') ? 'text-white' : 'text-violet-400/70 group-hover:text-violet-300' }}">assessment</span>
            <span class="relative truncate" x-show="!sidebarCollapsed" x-transition.opacity>Laporan & Export</span>
        </a>

    </nav>

    <!-- Footer Logout -->
    <div class="relative px-4 py-4 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-red-400/80 hover:text-red-300 hover:bg-red-500/10 transition-all group"
                :title="sidebarCollapsed ? 'Keluar' : ''">
                <span class="material-icons text-[20px] flex-shrink-0 group-hover:scale-110 transition-transform">logout</span>
                <span class="truncate" x-show="!sidebarCollapsed" x-transition.opacity>Keluar</span>
            </button>
        </form>
        <p x-show="!sidebarCollapsed" x-transition.opacity class="text-white/20 text-[10px] text-center mt-2 tracking-wider">v1.0 © {{ date('Y') }} Kemenag</p>
    </div>
</aside>
