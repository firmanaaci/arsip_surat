<?php

namespace App\Helpers;

use App\Models\SuratKeluar;
use Carbon\Carbon;

class KlasifikasiSuratHelper
{
    /**
     * Master Unit Pengolah Kemenag
     */
    public static function getUnitPengolah(): array
    {
        return [
            '1' => 'Subbag Tata Usaha (Subbag TU)',
            '2' => 'Seksi Pendidikan Madrasah (Penma)',
            '3' => 'Seksi Bimbingan Masyarakat Islam (Bimas Islam)',
            '4' => 'Seksi Penyelenggaraan Haji & Umrah (PHU)',
            '5' => 'Seksi Pendidikan Agama & Keagamaan Islam (PAKIS)',
            '6' => 'Penyelenggara Zakat dan Wakaf (Zawa)',
            '7' => 'Penyelenggara Kristen',
            '8' => 'Penyelenggara Katolik',
        ];
    }

    /**
     * Master Klasifikasi Tata Naskah Dinas Kemenag (KMA)
     */
    public static function getKlasifikasi(): array
    {
        return [
            'Kepegawaian (KP)' => [
                'KP.01.1' => 'KP.01.1 - Formasi & Pengadaan Pegawai',
                'KP.01.2' => 'KP.01.2 - Mutasi, Promosi, Penempatan Pegawai',
                'KP.04'   => 'KP.04 - Cuti & Izin Pegawai',
                'KP.07'   => 'KP.07 - Disiplin Pegawai & Sanksi',
                'KP.08'   => 'KP.08 - Kenaikan Pangkat & Gaji Berkala',
            ],
            'Pendidikan Madrasah & Keagamaan (PP)' => [
                'PP.00'   => 'PP.00 - Kurikulum & Pembelajaran',
                'PP.01'   => 'PP.01 - Asesmen & Ujian Madrasah',
                'PP.04'   => 'PP.04 - Bantuan Sarana & Prasarana',
                'PP.07'   => 'PP.07 - Pendidikan Diniyah & Pondok Pesantren',
            ],
            'Bimbingan Masyarakat Islam (BA)' => [
                'BA.00'   => 'BA.00 - Kemasjidan & Hisab Rukyat',
                'BA.01.1' => 'BA.01.1 - Kepenghuluan, Nikah & Rujuk (KUA)',
                'BA.03'   => 'BA.03 - Pengelolaan Zakat & Wakaf',
                'BA.04'   => 'BA.04 - Pembinaan Syariah & Halal',
            ],
            'Haji & Umrah (HJ)' => [
                'HJ.01'   => 'HJ.01 - Pendaftaran & Dokumen Paspor/Visa',
                'HJ.03'   => 'HJ.03 - Bimbingan Manasik & Pembinaan Jamaah',
            ],
            'Keuangan & BMN (KU)' => [
                'KU.01'   => 'KU.01 - Penyusunan Rencana Anggaran / DIPA',
                'KU.02'   => 'KU.02 - Pelaksanaan Anggaran & Perbendaharaan',
                'KU.03'   => 'KU.03 - Pengelolaan Barang Milik Negara (BMN)',
            ],
            'Hubungan Masyarakat & Protokol (HM)' => [
                'HM.00'   => 'HM.00 - Publikasi Informasi & Media',
                'HM.01'   => 'HM.01 - Keprotokolan & Undangan Resmi',
            ],
            'Kerukunan & Kerjasama (KS)' => [
                'KS.01'   => 'KS.01 - Kerukunan Umat Beragama & FKUB',
            ],
            'Organisasi & Tata Laksana (OT)' => [
                'OT.00'   => 'OT.00 - Struktur Organisasi & Anjab',
                'OT.01'   => 'OT.01 - Standar Operasional Prosedur (SOP)',
            ],
        ];
    }

    /**
     * Konversi Angka Bulan ke Romawi
     */
    public static function bulanKeRomawi(int $bulan): string
    {
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];
        return $romawi[$bulan] ?? 'I';
    }

    /**
     * Generate Nomor Surat Keluar Otomatis Berdasarkan Tata Naskah Kemenag
     * Format: B-[NomorUrut]/Kk.11.31/[KodeUnit]/[KodeKlasifikasi]/[BulanRomawi]/[Tahun]
     */
    public static function generateNomorSuratKeluar(string $unitCode, string $klasifikasiCode, ?string $tanggal = null): array
    {
        $date = $tanggal ? Carbon::parse($tanggal) : Carbon::today();
        $year = $date->year;
        $monthRomawi = self::bulanKeRomawi($date->month);

        // Hitung total surat keluar di tahun berjalan untuk nomor urut
        $countThisYear = SuratKeluar::whereYear('tanggal_surat', $year)->count();
        $nextNumber = str_pad($countThisYear + 1, 3, '0', STR_PAD_LEFT);

        // Satker Kemenag Kota Surakarta default: Kk.11.31
        $satkerCode = 'Kk.11.31';
        $nomorSurat = "B-{$nextNumber}/{$satkerCode}/{$unitCode}/{$klasifikasiCode}/{$monthRomawi}/{$year}";

        return [
            'nomor_surat' => $nomorSurat,
            'nomor_urut'  => $nextNumber,
            'satker'      => $satkerCode,
            'unit'        => $unitCode,
            'klasifikasi' => $klasifikasiCode,
            'bulan'       => $monthRomawi,
            'tahun'       => $year,
        ];
    }
}
