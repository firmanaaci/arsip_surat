<header class="relative z-30 flex items-center justify-between px-4 sm:px-6 py-3 border-b border-white/10"
    style="background: linear-gradient(90deg, #0f1f3d 0%, #1a3a5c 60%, #0d4a3a 100%); backdrop-filter: blur(16px); box-shadow: 0 2px 20px rgba(0,0,0,0.3);">

    <!-- Left: Sidebar Toggle + Breadcrumb -->
    <div class="flex items-center gap-3 sm:gap-4">

        <!-- Mobile Drawer Toggle Button (< lg) -->
        <button @click="sidebarOpen = !sidebarOpen"
            class="lg:hidden w-9 h-9 rounded-xl flex items-center justify-center text-white/80 bg-white/10 hover:bg-white/20 border border-white/15 transition-all"
            aria-label="Toggle Navigation">
            <span class="material-icons text-[20px]" x-text="sidebarOpen ? 'close' : 'menu'">menu</span>
        </button>

        <!-- Desktop Collapse Button (>= lg) -->
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="hidden lg:flex w-9 h-9 rounded-xl items-center justify-center text-white/80 bg-white/10 hover:bg-white/20 border border-white/15 transition-all"
            title="Expand/Collapse Sidebar">
            <span class="material-icons text-[20px]" x-text="sidebarCollapsed ? 'menu_open' : 'menu'">menu</span>
        </button>

        <!-- Breadcrumb / Active Page Indicator -->
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
            <span class="text-white/60 text-xs font-semibold tracking-wider uppercase truncate max-w-[140px] sm:max-w-xs">
                @php
                    $segments = request()->segments();
                    $last = end($segments);
                    $label = match(true) {
                        request()->routeIs('halamanutama') || request()->routeIs('dashboard') => 'Dashboard',
                        request()->routeIs('inputsuratmasuk') => 'Input Surat Masuk',
                        request()->routeIs('inputsuratkeluar') => 'Input Surat Keluar',
                        request()->routeIs('suratmasuk.index') => 'Tabel Surat Masuk',
                        request()->routeIs('suratkeluar.index') => 'Tabel Surat Keluar',
                        request()->routeIs('suratmasuk.show') => 'Detail Surat Masuk',
                        request()->routeIs('suratkeluar.show') => 'Detail Surat Keluar',
                        request()->routeIs('suratmasuk.edit') => 'Edit Surat Masuk',
                        request()->routeIs('suratkeluar.edit') => 'Edit Surat Keluar',
                        request()->is('laporan') => 'Laporan',
                        default => ucfirst($last ?? 'Halaman')
                    };
                @endphp
                {{ $label }}
            </span>
        </div>
    </div>

    <!-- Center: Brand Logo (Hidden on small screens to save space) -->
    <div class="hidden md:flex items-center gap-2.5 absolute left-1/2 -translate-x-1/2">
        <div class="w-7 h-7 rounded-lg bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center">
            <img src="{{ asset('logokemenag.png') }}" alt="Logo" class="w-4 h-4 object-contain">
        </div>
        <span class="text-white font-bold text-sm tracking-wide">Arsip Surat</span>
        <span class="text-emerald-300/80 font-medium text-xs">Kemenag</span>
    </div>

    <!-- Right: Clock & User Dropdown -->
    @auth
    <div class="flex items-center gap-3 sm:gap-4">

        <!-- Live Clock -->
        <div class="hidden sm:flex items-center gap-1.5 text-white/60 text-xs font-medium" id="header-clock">
            <span class="material-icons text-[15px] text-emerald-400">schedule</span>
            <span id="clock-time">...</span>
        </div>

        <!-- Divider -->
        <div class="hidden sm:block w-px h-5 bg-white/15"></div>

        <!-- User Dropdown -->
        <div class="relative" x-data="{ userMenuOpen: false }" @click.away="userMenuOpen = false">
            <button @click="userMenuOpen = !userMenuOpen"
                class="flex items-center gap-2 p-1.5 sm:px-3 sm:py-1.5 rounded-xl border border-white/10 hover:border-white/25 hover:bg-white/5 transition-all group">
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0 shadow-sm"
                    style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-white text-xs font-semibold leading-tight truncate max-w-[100px]">{{ Auth::user()->name }}</p>
                    <p class="text-emerald-300/70 text-[10px] leading-tight">{{ Auth::user()->role ?? 'Staff' }}</p>
                </div>
                <span class="material-icons text-white/40 text-[16px] group-hover:text-white/70 transition-transform duration-200"
                    :class="{ 'rotate-180': userMenuOpen }">expand_more</span>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="userMenuOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                 class="absolute right-0 mt-2 w-56 rounded-2xl border border-slate-200/60 bg-white shadow-2xl overflow-hidden z-50"
                 x-cloak>

                <div class="px-4 py-3 border-b border-slate-100" style="background: linear-gradient(135deg, #f0fdf4, #ecfdf5);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm"
                            style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-slate-800 text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold text-emerald-700 bg-emerald-100">
                                {{ Auth::user()->role ?? 'Staff' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="py-1.5">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors group">
                            <span class="material-icons text-[18px] group-hover:scale-110 transition-transform">logout</span>
                            Keluar dari Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endauth
</header>

<script>
    const hariID = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const bulanID = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    function updateClock() {
        const el = document.getElementById('clock-time');
        if (!el) return;
        const now = new Date();
        const hari  = hariID[now.getDay()];
        const tgl   = String(now.getDate()).padStart(2, '0');
        const bln   = bulanID[now.getMonth()];
        const jam   = String(now.getHours()).padStart(2, '0');
        const menit = String(now.getMinutes()).padStart(2, '0');
        el.textContent = hari + ', ' + tgl + ' ' + bln + ' · ' + jam + ':' + menit;
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>