# Arsip Surat Digital Kemenag Solo

<p align="center">
  <img src="public/logokemenag.png" alt="Logo Kemenag" width="100">
</p>

<p align="center">
  <b>Sistem Informasi Pengelolaan Surat Masuk, Surat Keluar, Disposisi, Laporan, dan Audit Arsip Digital</b>
  <br>
  <i>Aplikasi arsip surat untuk mendukung tata kelola administrasi Kantor Kementerian Agama Kota Surakarta.</i>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS v4">
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
  <img src="https://img.shields.io/badge/SweetAlert2-v11-7066E0?style=for-the-badge&logo=javascript&logoColor=white" alt="SweetAlert2">
</p>

---

## Daftar Isi

- [Tentang Sistem](#-tentang-sistem)
- [Fitur Utama &amp; Keunggulan](#-fitur-utama--keunggulan)
- [Hak Akses &amp; Hierarki Pengguna (RBAC)](#-hak-akses--hierarki-pengguna-rbac)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Panduan Instalasi &amp; Menjalankan](#-panduan-instalasi--menjalankan)
- [Akun Pengguna Default](#-akun-pengguna-default)
- [Pengujian Otomatis (Automated Tests)](#-pengujian-otomatis-automated-tests)
- [Lisensi](#-lisensi)

---

## Tentang Sistem

**E-Arsip Kemenag** adalah aplikasi manajemen persuratan digital terintegrasi untuk mendigitalkan surat masuk, surat keluar, disposisi pimpinan, penomoran otomatis, pencarian arsip, laporan, dan audit aktivitas. Aplikasi mengutamakan kemudahan penggunaan, keamanan, performa, serta rekam jejak pengelolaan data.

Aplikasi ini mengedepankan prinsip **keamanan tingkat tinggi, kemudahan penggunaan (_user-friendly_), performa cepat, dan kepatuhan terhadap audit (_audit trail_).**

---

## Fitur Utama & Keunggulan

### 1. Executive Dashboard & Real-Time Analytics

- **KPI Card Metrik**: Total Surat Masuk, Surat Keluar, Disposisi Aktif, dan Rasio Digitalisasi Berkas.
- **Tracker Tindak Lanjut Disposisi**: Memantau disposisi yang berstatus _Menunggu_, _Sedang Diproses_, dan _Selesai_.
- **Grafik Tren 12 Bulan**: Visualisasi volume pergerakan surat masuk dan keluar tahun berjalan.
- **Distribusi Kode Klasifikasi KMA**: Analisis kategori urusan surat yang paling sering diterbitkan.

### 2. Penomoran Otomatis Surat Keluar (KMA No. 9 Tahun 2016)

- Generator nomor surat dinas otomatis dengan format baku:
    $$
    \text{B-}[NoUrut]/\text{Kk.13.04}/[UnitKerja]/[\text{KodeKlasifikasi}]/[BulanRomawi]/[Tahun]
    $$
- Terintegrasi langsung dengan master kode klasifikasi Kemenag (Kepegawaian `KP`, Tata Usaha `OT`, Keuangan `KU`, Humas `HM`, Pendidikan Madrasah, Bimas Islam, dll.).

### 3. Sistem Disposisi Elektronik & Cetak Lembar Resmi

- Pimpinan dapat mendisposisikan surat masuk ke Kepala Seksi / Kasubbag TU dalam hitungan detik.
- Penerima disposisi dapat memperbarui catatan dan laporan hasil tindak lanjut.
- **Cetak Lembar Disposisi Standar Kemenag**: Format tata letak cetak resmi siap pakai (A4) lengkap dengan Kop Instansi, identitas surat, checklist instruksi, dan kolom paraf.

### 4. Pencarian dan Pengelolaan Arsip

- Menampilkan daftar surat masuk dan surat keluar secara terstruktur.
- Pencarian berdasarkan informasi surat, nomor, tanggal, dan kata kunci relevan.
- Lampiran surat dapat dipratinjau dan diunduh langsung dari halaman detail.
- Data arsip dapat diubah, dipindahkan ke tempat sampah, dipulihkan, atau dihapus permanen sesuai hak akses.

### 5. Laporan dan Rekap Arsip

- Ekspor laporan surat masuk dan surat keluar dalam format PDF atau Excel.
- Penyaringan laporan berdasarkan periode yang dibutuhkan.
- Dashboard menampilkan tren surat 12 bulan terakhir.
- Perubahan data dan aktivitas pengguna tercatat dalam audit trail.

### 6. Log Aktivitas & Rekam Jejak (Audit Trail)

- Pencatatan menyeluruh setiap ada aktivitas: `CREATE` (tambah), `UPDATE` (ubah), `DELETE` (hapus ke sampah), `RESTORE` (pulihkan), `FORCE_DELETE` (hapus permanen), `DOWNLOAD` (unduh/cetak), dan `LOGIN`.
- Dilengkapi pencatatan nama pengguna, peran, modul target, timestamp, alamat IP, dan perangkat (_user-agent_).
- Filter canggih berdasarkan teks, jenis aksi, pengguna, dan rentang tanggal.

### 7. Perlindungan Data Anti-Kehilangan (Soft Deletes & Tempat Sampah)

- Penghapusan data surat tidak langsung menghapus fisik berkas dari server, melainkan masuk ke **Tempat Sampah (_Recycle Bin_)**.
- Fitur **Pulihkan (_Restore_)** data satu per satu.
- Fitur **Musnahkan (_Force Delete_)** dan **Kosongkan Tempat Sampah** dengan konfirmasi SweetAlert2.

### 8. Notifikasi Dialog Interaktif (SweetAlert2 Terpusat)

- Modal dialog modern di tengah layar dengan animasi sukses, error, peringatan, dan hitung mundur otomatis (_auto-timer_).
- Konfirmasi penghapusan data elegan menggantikan dialog bawaan browser yang kaku.

---

## Hak Akses & Hierarki Pengguna (RBAC)

Aplikasi menerapkan **Role-Based Access Control** dengan 3 tingkatan hak akses:

| Peran (_Role_)                            | Hak Akses & Wewenang                                                                                                                                                              |
| :---------------------------------------- | :-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Arsiparis / Administrator (`admin`)**   | Akses penuh ke seluruh sistem: input & kelola surat masuk/keluar, scan dokumen, kelola akun pengguna, buka audit trail, serta mengelola tempat sampah (_restore / force delete_). |
| **Kepala Kantor / Pimpinan (`pimpinan`)** | Akses dashboard analitik eksekutif, meninjau seluruh arsip surat, membuat & mencetak lembar disposisi, dan memantau log aktivitas.                                                |
| **Kepala Seksi / Staf Pengolah (`staf`)** | Mengakses daftar surat masuk dan lembar disposisi yang ditugaskan ke unit kerjanya, serta mengunggah progres/laporan hasil tindak lanjut.                                         |

---

## Teknologi yang Digunakan

- **Framework**: [Laravel 12](https://laravel.com/)
- **Bahasa Pemrograman**: PHP 8.2+
- **Styling & Desain**: [Tailwind CSS v4](https://tailwindcss.com/)
- **Interaktivitas Frontend**: [Alpine.js](https://alpinejs.dev/)
- **Komponen Reaktif**: [Livewire 3](https://livewire.laravel.com/) & [Volt](https://livewire.laravel.com/docs/volt)
- **Notifikasi & Dialog**: [SweetAlert2](https://sweetalert2.github.io/)
- **Tipografi**: [Plus Jakarta Sans](https://fonts.google.com/specimen/Plus+Jakarta+Sans) (Google Fonts)
- **Database**: MySQL / MariaDB (Mendukung SQLite)
- **Unit Testing**: [Pest PHP](https://pestphp.com/)

---

## Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan komputer Anda telah terpasang:

- **PHP** >= 8.2 (dengan ekstensi `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`, `curl`)
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM**
- **MySQL** / MariaDB Server

---

## Panduan Instalasi & Menjalankan

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan lokal:

### 1. Clone Repository

```bash
git clone https://github.com/firmanaaci/arsip_surat.git
cd arsip_surat
```

### 2. Install Dependensi PHP & Node.js

```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Sesuaikan konfigurasi database pada berkas `.env`:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arsipp
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key & Symbolic Link Storage

```bash
php artisan key:generate
php artisan storage:link
```

### 5. Jalankan Migrasi & Database Seeder

```bash
php artisan migrate --seed
```

### 6. Build Aset Frontend & Jalankan Server Dev

Jalankan server aplikasi dan Vite secara bersamaan:

```bash
composer run dev
```

Aplikasi kini dapat dibuka di peramban pada alamat:
**`http://localhost:8000`** atau **`http://127.0.0.1:8000`**

---

## Akun Pengguna Default

Seeder utama menyediakan akun administrator berikut:

| Peran / Jabatan   | Alamat Email      | Password Default |
| :---------------- | :---------------- | :--------------- |
| **Administrator** | `admin@gmail.com` | `admin1`         |

Database seeder juga membuat akun uji `test@example.com` dengan password `password` dan peran `user`.

---

## Pengujian Otomatis (Automated Tests)

Sistem telah dilengkapi dengan pengujian menyeluruh (Unit Test & Feature Test) menggunakan **Pest PHP**.

Untuk menjalankan seluruh rangkaian pengujian:

```bash
php artisan test
```

**Hasil Pengujian:**

```text
   PASS  Tests\Unit\ExampleTest
   PASS  Tests\Feature\Auth\AuthenticationTest
   PASS  Tests\Feature\Auth\EmailVerificationTest
   PASS  Tests\Feature\Auth\PasswordConfirmationTest
   PASS  Tests\Feature\Auth\PasswordResetTest
   PASS  Tests\Feature\Auth\PasswordUpdateTest
   PASS  Tests\Feature\Auth\RegistrationTest
   PASS  Tests\Feature\DashboardTest
   PASS  Tests\Feature\ExampleTest
   PASS  Tests\Feature\ProfileTest
   PASS  Tests\Feature\Settings\PasswordUpdateTest
   PASS  Tests\Feature\Settings\ProfileUpdateTest

   Tests:    34 passed (85 assertions)
   Duration: ~40s
```

---

## 📄 Lisensi

Aplikasi ini dikembangkan di bawah lisensi terbuka [MIT License](LICENSE).
Hak Cipta © 2026 **Kementerian Agama Republik Indonesia**.
