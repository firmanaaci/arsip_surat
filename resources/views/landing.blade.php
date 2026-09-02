@extends('layouts.public')

@section('content')

    <!-- ===========================
     NAVBAR
=========================== -->
    <nav class="navbar" id="main-navbar">
        <a href="{{ route('home') }}" class="nav-brand">
            <div class="nav-logo-box">
                <img src="{{ asset('logokemenag.png') }}" alt="Logo Kemenag">
            </div>
            <div class="nav-brand-text">
                <p>Arsip Surat</p>
                <p>Kemenag</p>
            </div>
        </a>

        <!-- Desktop nav links -->
        <div class="nav-links">
            <a href="#fitur">Fitur</a>
            <a href="#statistik">Statistik</a>
            <a href="#tentang">Tentang</a>
        </div>

        <!-- Desktop actions -->
        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn-green">
                <span class="material-icons" style="font-size:16px!important">login</span>
                Mulai Sekarang
            </a>

            <!-- Mobile: icon-only login -->
            <a href="{{ route('login') }}" class="btn-green-icon" title="Masuk">
                <span class="material-icons">login</span>
            </a>

            <!-- Mobile: hamburger -->
            <button class="nav-hamburger" id="nav-toggle" aria-label="Buka menu" onclick="toggleNavDrawer()">
                <span class="material-icons" id="nav-toggle-icon">menu</span>
            </button>
        </div>
    </nav>

    <!-- Mobile nav drawer -->
    <div class="nav-drawer" id="nav-drawer">
        <a href="#fitur" onclick="closeNavDrawer()">
            <span class="material-icons">stars</span>
            Fitur
        </a>
        <a href="#statistik" onclick="closeNavDrawer()">
            <span class="material-icons">bar_chart</span>
            Statistik
        </a>
        <a href="#tentang" onclick="closeNavDrawer()">
            <span class="material-icons">info</span>
            Tentang
        </a>
        <div class="nav-drawer-divider"></div>
        <div class="nav-drawer-cta">
            <a href="{{ route('login') }}">
                <span class="material-icons">rocket_launch</span>
                Mulai Gunakan Sistem
            </a>
        </div>
    </div>


    <!-- ===========================
     HERO
=========================== -->
    <section class="hero">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <!-- Logo with ripple -->
        <div class="ripple-wrap">
            <div class="ripple-ring"></div>
            <div class="ripple-ring"></div>
            <div class="ripple-ring"></div>
            <div class="logo-center">
                <img src="{{ asset('logokemenag.png') }}" alt="Logo Kemenag">
            </div>
        </div>

        <!-- Badge -->
        <div class="hero-badge">
            <div class="dot"></div>
            <span>Sistem Digital Resmi</span>
        </div>

        <!-- Title -->
        <h1 class="hero-title">
            Kelola <span class="text-gradient">Arsip Surat</span><br>
            Lebih Cerdas & Efisien
        </h1>

        <!-- Subtitle -->
        <p class="hero-sub">
            Platform manajemen arsip surat digital terpadu untuk Kementerian Agama.
            Kelola surat masuk dan keluar dengan mudah, cepat, dan terorganisir.
        </p>

        <!-- CTA -->
        <div class="hero-buttons">
            <a href="{{ route('login') }}" class="btn-hero-primary">
                <span class="material-icons" style="font-size:22px!important">rocket_launch</span>
                Mulai Gunakan Sistem
            </a>
            <a href="#fitur" class="btn-hero-outline">
                <span class="material-icons" style="font-size:22px!important">explore</span>
                Lihat Fitur
            </a>
        </div>

        <!-- Scroll hint -->
        <div class="scroll-hint">
            <span style="letter-spacing:0.18em;">Scroll</span>
            <span class="material-icons" style="font-size:22px!important">expand_more</span>
        </div>
    </section>


    <!-- ===========================
     TICKER
=========================== -->
    <div class="ticker-section">
        <div class="ticker-track">
            @php $items = ['Surat Masuk','Surat Keluar','Laporan Digital','Pencarian Cepat','Export PDF','Manajemen Arsip','Kemenag RI','Sistem Terintegrasi','Data Aman','Akses Kapan Saja']; @endphp
            @foreach(array_merge($items, $items) as $item)
            <div class="ticker-item">
                <div class="ticker-dot"></div>
                <span>{{ $item }}</span>
            </div>
            @endforeach
        </div>
    </div>


    <!-- ===========================
     STATS
=========================== -->
    <section id="statistik" class="stats-section">
        <div class="stats-grid">
            <div class="stat-card reveal">
                <div class="stat-icon-box" style="background: linear-gradient(135deg,#10b981,#059669);">
                    <span class="material-icons">eco</span>
                </div>
                <div class="stat-value">100%</div>
                <div class="stat-label">Digital & Paperless</div>
            </div>
            <div class="stat-card reveal" style="transition-delay:0.1s">
                <div class="stat-icon-box" style="background: linear-gradient(135deg,#3b82f6,#4f46e5);">
                    <span class="material-icons">access_time_filled</span>
                </div>
                <div class="stat-value">24/7</div>
                <div class="stat-label">Akses Kapan Saja</div>
            </div>
            <div class="stat-card reveal" style="transition-delay:0.2s">
                <div class="stat-icon-box" style="background: linear-gradient(135deg,#8b5cf6,#7c3aed);">
                    <span class="material-icons">cloud_done</span>
                </div>
                <div class="stat-value">∞</div>
                <div class="stat-label">Kapasitas Penyimpanan</div>
            </div>
            <div class="stat-card reveal" style="transition-delay:0.3s">
                <div class="stat-icon-box" style="background: linear-gradient(135deg,#f59e0b,#d97706);">
                    <span class="material-icons">bolt</span>
                </div>
                <div class="stat-value">1×</div>
                <div class="stat-label">Input Sekali Selesai</div>
            </div>
        </div>
    </section>


    <!-- ===========================
     FEATURES
=========================== -->
    <section id="fitur" class="features-section">
        <div class="section-header reveal">
            <div class="section-badge badge-emerald">
                <span class="material-icons">stars</span>
                Fitur Unggulan
            </div>
            <h2 class="section-title">Semua yang Anda Butuhkan</h2>
            <p class="section-subtitle">Sistem arsip surat yang dirancang untuk memudahkan pengelolaan dokumen di lingkungan Kementerian Agama.</p>
        </div>

        <div class="features-grid">
            <div class="feat-card reveal" style="border-top: 3px solid #3b82f6;">
                <div class="feat-icon-row">
                    <div class="feat-icon-box icon-blue"><span class="material-icons">move_to_inbox</span></div>
                    <span class="feat-tag">Input & Tracking</span>
                </div>
                <div class="feat-title">Surat Masuk</div>
                <div class="feat-desc">Catat dan kelola semua surat masuk dengan detail lengkap. Lampirkan file, tandai prioritas, dan lacak status penanganan.</div>
            </div>
            <div class="feat-card reveal" style="border-top: 3px solid #f59e0b; transition-delay:0.08s">
                <div class="feat-icon-row">
                    <div class="feat-icon-box icon-amber"><span class="material-icons">outbox</span></div>
                    <span class="feat-tag">Administrasi</span>
                </div>
                <div class="feat-title">Surat Keluar</div>
                <div class="feat-desc">Buat, daftarkan, dan arsipkan surat keluar secara sistematis. Nomor surat terurut otomatis untuk kemudahan administrasi.</div>
            </div>
            <div class="feat-card reveal" style="border-top: 3px solid #10b981; transition-delay:0.16s">
                <div class="feat-icon-row">
                    <div class="feat-icon-box icon-emerald"><span class="material-icons">search</span></div>
                    <span class="feat-tag">Smart Search</span>
                </div>
                <div class="feat-title">Pencarian Cepat</div>
                <div class="feat-desc">Temukan surat yang Anda butuhkan dalam hitungan detik. Filter berdasarkan tanggal, nomor, atau kata kunci.</div>
            </div>
            <div class="feat-card reveal" style="border-top: 3px solid #f43f5e; transition-delay:0.24s">
                <div class="feat-icon-row">
                    <div class="feat-icon-box icon-rose"><span class="material-icons">picture_as_pdf</span></div>
                    <span class="feat-tag">Report</span>
                </div>
                <div class="feat-title">Laporan & Export</div>
                <div class="feat-desc">Generate laporan dalam format PDF atau Excel. Rekap bulanan dan tahunan tersedia dengan satu klik.</div>
            </div>
            <div class="feat-card reveal" style="border-top: 3px solid #8b5cf6; transition-delay:0.32s">
                <div class="feat-icon-row">
                    <div class="feat-icon-box icon-violet"><span class="material-icons">security</span></div>
                    <span class="feat-tag">Secure</span>
                </div>
                <div class="feat-title">Keamanan Data</div>
                <div class="feat-desc">Data tersimpan aman dengan sistem autentikasi berlapis. Hanya pengguna terotorisasi yang dapat mengakses sistem.</div>
            </div>
            <div class="feat-card reveal" style="border-top: 3px solid #06b6d4; transition-delay:0.4s">
                <div class="feat-icon-row">
                    <div class="feat-icon-box icon-cyan"><span class="material-icons">devices</span></div>
                    <span class="feat-tag">Responsive</span>
                </div>
                <div class="feat-title">Akses Multi-Device</div>
                <div class="feat-desc">Gunakan dari komputer, tablet, maupun smartphone. Antarmuka responsif yang nyaman di semua ukuran layar.</div>
            </div>
        </div>
    </section>


    <!-- ===========================
     HOW IT WORKS
=========================== -->
    <section class="how-section">
        <div class="section-header reveal">
            <div class="section-badge badge-blue">
                <span class="material-icons">map</span>
                Cara Kerja
            </div>
            <h2 class="section-title">Mudah Digunakan</h2>
            <p class="section-subtitle">Tiga langkah sederhana untuk mulai mengelola arsip surat digital Anda.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card reveal">
                <div class="step-icon-wrap" style="background: linear-gradient(135deg,#10b981,#059669);">
                    <span class="material-icons">login</span>
                    <span class="step-num">01</span>
                </div>
                <div class="step-title">Login ke Sistem</div>
                <div class="step-desc">Masuk dengan akun yang telah disiapkan oleh administrator. Aman dan terenkripsi.</div>
            </div>
            <div class="step-card reveal" style="transition-delay:0.15s">
                <div class="step-icon-wrap" style="background: linear-gradient(135deg,#3b82f6,#4f46e5);">
                    <span class="material-icons">edit_note</span>
                    <span class="step-num">02</span>
                </div>
                <div class="step-title">Input Data Surat</div>
                <div class="step-desc">Isi formulir surat masuk atau keluar dengan lengkap. Upload lampiran bila diperlukan.</div>
            </div>
            <div class="step-card reveal" style="transition-delay:0.3s">
                <div class="step-icon-wrap" style="background: linear-gradient(135deg,#8b5cf6,#7c3aed);">
                    <span class="material-icons">task_alt</span>
                    <span class="step-num">03</span>
                </div>
                <div class="step-title">Arsip Tersimpan</div>
                <div class="step-desc">Surat tersimpan otomatis dan dapat dicari kapan saja. Generate laporan sesuai kebutuhan.</div>
            </div>
        </div>
    </section>


    <!-- ===========================
     CTA DARK
=========================== -->
    <section id="tentang" class="cta-section">
        <div class="cta-orb-1"></div>
        <div class="cta-orb-2"></div>

        <div class="cta-brand reveal">
            <div class="cta-logo">
                <img src="{{ asset('logokemenag.png') }}" alt="Logo">
            </div>
            <div class="cta-brand-info">
                <p class="cta-brand-name">Kementerian Agama</p>
                <p class="cta-brand-sub">Kota Surakarta</p>
            </div>
        </div>

        <h2 class="cta-title reveal">
            Siap Transformasi<br>
            <span class="text-gradient">Arsip Anda?</span>
        </h2>

        <p class="cta-sub reveal">
            Bergabunglah dengan sistem arsip digital Kemenag. Mulai perjalanan menuju administrasi yang lebih efisien dan terdigitalisasi sepenuhnya.
        </p>

        <div class="reveal">
            <a href="{{ route('login') }}" class="btn-hero-primary">
                <span class="material-icons" style="font-size:22px!important">rocket_launch</span>
                Akses Sistem Sekarang
            </a>
        </div>

        <div class="trust-row reveal">
            <div class="trust-item">
                <span class="material-icons">verified</span>
                Sistem Terverifikasi
            </div>
            <div class="trust-dot"></div>
            <div class="trust-item">
                <span class="material-icons">lock</span>
                Data Terenkripsi
            </div>
            <div class="trust-dot"></div>
            <div class="trust-item">
                <span class="material-icons">support_agent</span>
                Dukungan Teknis
            </div>
        </div>
    </section>


    <!-- ===========================
     FOOTER
=========================== -->
    <footer class="footer">
        <div class="footer-main">
            <!-- Brand col -->
            <div>
                <div class="footer-brand">
                    <div class="footer-logo">
                        <img src="{{ asset('logokemenag.png') }}" alt="Logo">
                    </div>
                    <div class="footer-brand-name">
                        <p>Arsip Surat Kemenag</p>
                        <p>Sistem Pengarsipan Digital</p>
                    </div>
                </div>
                <p class="footer-desc">Sistem manajemen arsip surat digital untuk mendukung tata kelola administrasi yang efisien di lingkungan Kementerian Agama Kota Surakarta.</p>
            </div>

            <!-- Nav col -->
            <div>
                <div class="footer-heading">Navigasi</div>
                <ul class="footer-links">
                    <li><a href="{{ route('dashboard') }}"><span class="material-icons">chevron_right</span>Dashboard</a></li>
                    <li><a href="{{ route('suratmasuk.index') }}"><span class="material-icons">chevron_right</span>Surat Masuk</a></li>
                    <li><a href="{{ route('suratkeluar.index') }}"><span class="material-icons">chevron_right</span>Surat Keluar</a></li>
                    <li><a href="{{ route('laporan.index') }}"><span class="material-icons">chevron_right</span>Laporan</a></li>
                    <li><a href="{{ route('login') }}"><span class="material-icons">chevron_right</span>Masuk ke Sistem</a></li>
                </ul>
            </div>

            <!-- Info col -->
            <div>
                <div class="footer-heading">Informasi</div>
                <div class="footer-info-item">
                    <span class="material-icons">location_on</span>
                    <span>Kementerian Agama Kota Surakarta</span>
                </div>
                <div class="footer-info-item">
                    <span class="material-icons">language</span>
                    <span>kemenag</span>
                </div>
                <div class="footer-info-item">
                    <span class="material-icons">verified_user</span>
                    <span>Sistem Terverifikasi Resmi</span>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom">
            <p class="footer-copy">© {{ date('Y') }} Kementerian Agama Kota Surakarta. Hak Cipta Dilindungi.</p>
            <div class="footer-made">
                <span class="material-icons">favorite</span>
                Dibuat untuk kemudahan administrasi digital
            </div>
        </div>
    </footer>


    <script>
        // Scroll reveal
        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px'
        });
        revealEls.forEach(el => observer.observe(el));

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                e.preventDefault();
                const target = document.querySelector(a.getAttribute('href'));
                if (target) target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });

        // ===== Mobile nav drawer =====
        function toggleNavDrawer() {
            const drawer = document.getElementById('nav-drawer');
            const icon = document.getElementById('nav-toggle-icon');
            const isOpen = drawer.classList.contains('open');
            if (isOpen) {
                drawer.classList.remove('open');
                icon.textContent = 'menu';
            } else {
                drawer.classList.add('open');
                icon.textContent = 'close';
            }
        }

        function closeNavDrawer() {
            const drawer = document.getElementById('nav-drawer');
            const icon = document.getElementById('nav-toggle-icon');
            drawer.classList.remove('open');
            icon.textContent = 'menu';
        }

        // Close drawer when clicking outside
        document.addEventListener('click', function(e) {
            const drawer = document.getElementById('nav-drawer');
            const toggle = document.getElementById('nav-toggle');
            if (drawer && toggle && !drawer.contains(e.target) && !toggle.contains(e.target)) {
                closeNavDrawer();
            }
        });

        // Close drawer on scroll
        window.addEventListener('scroll', function() {
            closeNavDrawer();
        }, {
            passive: true
        });
    </script>

@endsection