<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Surat Digital | Kementerian Agama</title>
    <link rel="icon" type="image/png" href="{{ asset('logokemenag.png') }}">
    {{-- Preconnect Google Fonts for performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .sidebar-scrollbar::-webkit-scrollbar { width: 4px; }
        .sidebar-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 999px; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-screen flex flex-col overflow-hidden bg-slate-100/80 text-slate-800 antialiased" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">

    <div class="h-screen flex flex-col overflow-hidden">

        {{-- Header --}}
        @include('partials.header')

        <div class="flex flex-1 overflow-hidden">

            {{-- Mobile Overlay Backdrop --}}
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
                 x-cloak></div>

            {{-- Sidebar --}}
            @include('partials.sidebar')

            {{-- Main Content Area --}}
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 min-w-0">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Flash Messages Data Island (Linter-Safe & Clean) --}}
    <script type="application/json" id="flash-messages">
    {
        "success": @json(session('success')),
        "error": @json(session('error') ?? ($errors->any() ? $errors->first() : null)),
        "warning": @json(session('warning')),
        "info": @json(session('info'))
    }
    </script>

    {{-- Centralized SweetAlert2 Modal & Confirm Handler --}}
    <script>
        // Trigger SweetAlert2 Modal from Flash Data
        try {
            const flashEl = document.getElementById('flash-messages');
            if (flashEl) {
                const flash = JSON.parse(flashEl.textContent || '{}');

                if (flash.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: flash.success,
                        timer: 2600,
                        timerProgressBar: true,
                        showConfirmButton: true,
                        confirmButtonText: 'Selesai',
                        confirmButtonColor: '#10b981',
                        customClass: {
                            popup: 'rounded-3xl shadow-2xl border border-slate-100 font-sans p-6',
                            title: 'text-xl font-extrabold text-slate-800',
                            htmlContainer: 'text-sm text-slate-600',
                            confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-xs shadow-md shadow-emerald-500/20'
                        }
                    });
                } else if (flash.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: flash.error,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Tutup',
                        customClass: {
                            popup: 'rounded-3xl shadow-2xl border border-slate-100 font-sans p-6',
                            title: 'text-xl font-extrabold text-slate-800',
                            htmlContainer: 'text-sm text-slate-600',
                            confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-xs shadow-md shadow-red-500/20'
                        }
                    });
                } else if (flash.warning) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian!',
                        text: flash.warning,
                        confirmButtonColor: '#f59e0b',
                        confirmButtonText: 'Mengerti',
                        customClass: {
                            popup: 'rounded-3xl shadow-2xl border border-slate-100 font-sans p-6',
                            title: 'text-xl font-extrabold text-slate-800',
                            htmlContainer: 'text-sm text-slate-600',
                            confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-xs shadow-md'
                        }
                    });
                } else if (flash.info) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Informasi',
                        text: flash.info,
                        confirmButtonColor: '#3b82f6',
                        confirmButtonText: 'OK',
                        customClass: {
                            popup: 'rounded-3xl shadow-2xl border border-slate-100 font-sans p-6',
                            title: 'text-xl font-extrabold text-slate-800',
                            htmlContainer: 'text-sm text-slate-600',
                            confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-xs shadow-md'
                        }
                    });
                }
            }
        } catch (e) {
            console.error('Error parsing flash message:', e);
        }

        // Global SweetAlert2 Confirm Delete Helper
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form[data-confirm-delete]').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const msg = form.getAttribute('data-confirm-delete') || 'Data ini akan dihapus secara permanen dari sistem arsip.';
                    Swal.fire({
                        title: 'Konfirmasi Hapus?',
                        text: msg,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Hapus Data',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            popup: 'rounded-3xl shadow-2xl border border-slate-100 p-6 font-sans',
                            confirmButton: 'rounded-xl font-bold px-5 py-2.5 shadow-md shadow-red-500/20',
                            cancelButton: 'rounded-xl font-semibold px-5 py-2.5'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

        // Prevent Back Button History Cache After Logout (Force Reload & Re-Auth)
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (window.performance && window.performance.getEntriesByType && window.performance.getEntriesByType("navigation")[0]?.type === "back_forward")) {
                window.location.reload();
            }
        });

        // SPA navigation: ambil halaman baru lalu jalankan ulang script-nya
        document.addEventListener('click', function (event) {
            const link = event.target.closest('#sidebar a[href], main a[href]');
            if (!link) return;

            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;
            if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

            event.preventDefault();

            fetch(href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => {
                    if (!response.ok) throw new Error('HTTP ' + response.status);
                    return response.text();
                })
                .then(html => {
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const newMain = doc.querySelector('main');
                    const newSidebar = doc.querySelector('#sidebar');

                    if (!newMain) {
                        window.location.assign(href);
                        return;
                    }

                    document.querySelector('main').innerHTML = newMain.innerHTML;

                    if (newSidebar) {
                        const currentSidebar = document.querySelector('#sidebar');
                        if (currentSidebar) currentSidebar.innerHTML = newSidebar.innerHTML;
                    }

                    if (doc.title) document.title = doc.title;
                    history.pushState({}, '', href);

                    const scripts = [...document.querySelector('main').querySelectorAll('script')];
                    const runScripts = async () => {
                        for (const oldScript of scripts) {
                            if (oldScript.type === 'application/json') continue;

                            const script = document.createElement('script');
                            for (const attr of oldScript.attributes) {
                                script.setAttribute(attr.name, attr.value);
                            }

                            if (oldScript.src) {
                                await new Promise(resolve => {
                                    script.onload = resolve;
                                    script.onerror = resolve;
                                    oldScript.replaceWith(script);
                                });
                            } else {
                                script.textContent = oldScript.textContent;
                                oldScript.replaceWith(script);
                            }
                        }
                    };

                    runScripts();
                    document.querySelector('main').scrollTo({ top: 0, behavior: 'instant' });
                })
                .catch(() => window.location.assign(href));
        });

        window.addEventListener('popstate', function () {
            window.location.reload();
        });
    </script>

</body>
</html>
