<x-guest-layout>
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-emerald-100 via-white to-cyan-100 px-4 py-8 sm:px-6">
        <div class="pointer-events-none absolute -left-20 top-12 h-64 w-64 rounded-full bg-emerald-300/35 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-16 -top-6 h-64 w-64 rounded-full bg-cyan-300/35 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-0 left-1/3 h-56 w-56 rounded-full bg-lime-200/40 blur-3xl"></div>

        <div class="relative flex w-full max-w-6xl overflow-hidden rounded-3xl border border-white/60 bg-white/90 shadow-[0_20px_70px_-30px_rgba(16,24,40,0.45)] backdrop-blur">
            <div class="w-full p-6 sm:p-8 md:w-1/2 md:p-10 lg:p-12">

                {{-- Tombol kembali ke landing page --}}
                <div class="mb-6">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm font-medium text-slate-600 shadow-sm transition duration-200 hover:-translate-x-0.5 hover:border-emerald-300 hover:text-emerald-700 hover:shadow-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>

                <p class="mb-3 inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-emerald-700">
                    Arsip Surat
                </p>
                <h2 class="text-3xl font-semibold tracking-tight text-slate-800 sm:text-4xl">Masuk ke Akun</h2>
                <p class="mt-2 mb-8 text-sm text-slate-600 sm:mb-10 sm:text-base">Silakan masuk untuk melanjutkan pengelolaan surat masuk dan surat keluar.</p>

                <form method="POST" action="{{ route('login') }}" class="space-y-5 sm:space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email</label>
                        <x-text-input 
                            id="email" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            placeholder="you@example.com"
                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm placeholder:text-slate-400 transition duration-200 focus:border-emerald-500 focus:ring-emerald-500" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-sm text-red-500" />
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Password</label>
                        <x-text-input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            placeholder="********"
                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-2.5 text-slate-800 shadow-sm placeholder:text-slate-400 transition duration-200 focus:border-emerald-500 focus:ring-emerald-500" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-sm text-red-500" />
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <span class="ml-2 text-slate-600">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-medium text-emerald-700 transition duration-200 hover:text-emerald-800 hover:underline">Lupa password?</a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 py-3 font-semibold text-white shadow-lg shadow-emerald-800/20 transition duration-300 hover:-translate-y-0.5 hover:from-emerald-700 hover:to-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>

            <div class="relative hidden w-1/2 items-center justify-center overflow-hidden bg-gradient-to-br from-emerald-700 via-emerald-800 to-teal-900 p-10 md:flex">
                <div class="absolute -left-8 top-8 h-40 w-40 rounded-full border border-white/15"></div>
                <div class="absolute right-8 bottom-10 h-48 w-48 rounded-full border border-white/10"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.14),transparent_38%)]"></div>

                <div class="relative text-center text-white">
                    <img src="{{ asset('logokemenag.png') }}" alt="Logo Kemenag" class="mx-auto w-40 drop-shadow-2xl lg:w-48">
                    <h3 class="mt-6 text-2xl font-semibold tracking-tight">Sistem Arsip Surat</h3>
                    <p class="mx-auto mt-2 max-w-xs text-sm text-emerald-100/90">Aman, terstruktur, dan siap membantu pengelolaan dokumen harian Anda.</p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>