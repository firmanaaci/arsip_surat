@extends('layouts.public')

@section('content')

<div class="lp">

    {{-- HEADER (tetap di atas saat scroll) --}}
    <header class="lp-nav" id="main-navbar">
        <div class="lp-wrap lp-nav-inner">
            <a href="{{ route('home') }}" class="lp-brand" aria-label="Beranda Arsip Surat">
                <span class="lp-brand-logo">
                    <img src="{{ asset('logokemenag.png') }}" alt="Logo Kementerian Agama">
                </span>
                <span class="lp-brand-text">
                    Arsip Surat
                    <span>Kementerian Agama Kota Surakarta</span>
                </span>
            </a>

            <nav class="lp-nav-links" aria-label="Navigasi utama">
                <a href="#fitur" class="lp-link">
                    <span class="material-icons" aria-hidden="true">widgets</span>
                    Fitur
                </a>
                <a href="{{ route('login') }}" class="lp-btn lp-btn-primary lp-btn-sm lp-login-btn">
                    <span class="material-icons" aria-hidden="true">login</span>
                    Masuk
                </a>
            </nav>
        </div>
    </header>


    {{-- HERO --}}
    <section class="lp-hero">
        <div class="lp-wrap">
            <div class="lp-rule lp-in" style="--i:0"></div>
            <h1 class="lp-in" style="--i:1">Arsip surat masuk dan keluar, dalam satu sistem.</h1>
            <p class="lp-in" style="--i:2">
                Catat, cari, dan buat laporan surat dengan cepat.
            </p>
            <div class="lp-hero-actions lp-in" style="--i:3">
                <a href="{{ route('login') }}" class="lp-btn lp-btn-primary">Masuk ke sistem</a>
                <a href="#fitur" class="lp-btn lp-btn-ghost">Lihat fitur</a>
            </div>
        </div>
    </section>


    {{-- FEATURES --}}
    <section id="fitur" class="lp-features-section">
        <div class="lp-wrap">
            <h2 class="lp-reveal">Fitur utama</h2>

            <div class="lp-features">
                <div class="lp-feature lp-reveal" style="--i:0">
                    <h3>Surat masuk</h3>
                    <p>Catat surat, lampirkan file, dan lacak status penanganan.</p>
                </div>
                <div class="lp-feature lp-reveal" style="--i:1">
                    <h3>Surat keluar</h3>
                    <p>Daftarkan surat dengan nomor yang terurut otomatis.</p>
                </div>
                <div class="lp-feature lp-reveal" style="--i:2">
                    <h3>Pencarian</h3>
                    <p>Cari berdasarkan tanggal, nomor, atau kata kunci.</p>
                </div>
                <div class="lp-feature lp-reveal" style="--i:3">
                    <h3>Laporan</h3>
                    <p>Ekspor rekap bulanan dan tahunan ke PDF atau Excel.</p>
                </div>
            </div>
        </div>
    </section>


    {{-- FOOTER --}}
    <footer class="lp-footer">
        <div class="lp-wrap lp-footer-inner">
            <div class="lp-footer-brand">
                <img src="{{ asset('logokemenag.png') }}" alt="Logo">
                Arsip Surat Kemenag
            </div>
            <div>© {{ date('Y') }} Kementerian Agama Kota Surakarta</div>
        </div>
    </footer>

</div>

<script>
    document.documentElement.classList.add('js');

    // Bayangan pada header setelah halaman di-scroll
    (function () {
        const nav = document.getElementById('main-navbar');
        const update = () => nav.classList.toggle('scrolled', window.scrollY > 8);
        update();
        window.addEventListener('scroll', update, { passive: true });
    })();

    // Muncul perlahan saat masuk viewport
    (function () {
        const els = document.querySelectorAll('.lp-reveal');
        if (!('IntersectionObserver' in window)) {
            els.forEach(el => el.classList.add('visible'));
            return;
        }
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        els.forEach(el => io.observe(el));
    })();
</script>

@endsection