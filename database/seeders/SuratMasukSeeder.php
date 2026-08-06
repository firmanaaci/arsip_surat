<?php

namespace Database\Seeders;

use App\Models\SuratMasuk;
use Illuminate\Database\Seeder;

class SuratMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nomor_surat' => 'SM-2026-0001',
                'tanggal_surat' => '2026-07-01',
                'pengirim' => 'Dinas Pendidikan Kota',
                'perihal' => 'Permohonan Data Sekolah',
                'kategori' => 'Administrasi',
                'status_surat' => 'Masuk',
                'sifat_surat' => 'Biasa',
                'tujuan_surat' => 'Kepala Sekolah',
                'petunjuk' => 'Tindak lanjuti sesuai prosedur',
                'catatan' => 'Perlu balasan paling lambat 7 hari kerja',
                'isi_disposisi' => 'Disposisi ke bagian tata usaha untuk diproses.',
                'disposisi_kasubbag' => 'Setuju untuk diproses',
                'file' => 'surat_masuk/sm-2026-0001.pdf',
            ],
            [
                'nomor_surat' => 'SM-2026-0002',
                'tanggal_surat' => '2026-07-15',
                'pengirim' => 'Badan Kepegawaian Daerah',
                'perihal' => 'Undangan Sosialisasi Aplikasi',
                'kategori' => 'Undangan',
                'status_surat' => 'Masuk',
                'sifat_surat' => 'Segera',
                'tujuan_surat' => 'Wakil Kepala Sekolah',
                'petunjuk' => 'Hadiri sesuai jadwal',
                'catatan' => null,
                'isi_disposisi' => 'Disampaikan kepada yang bersangkutan.',
                'disposisi_kasubbag' => 'Untuk diketahui dan ditindaklanjuti',
                'file' => 'surat_masuk/sm-2026-0002.pdf',
            ],
            [
                'nomor_surat' => 'SM-2026-0003',
                'tanggal_surat' => '2026-08-01',
                'pengirim' => 'Kementerian Pendidikan',
                'perihal' => 'Pemberitahuan Monitoring Kegiatan',
                'kategori' => 'Pemberitahuan',
                'status_surat' => 'Masuk',
                'sifat_surat' => 'Penting',
                'tujuan_surat' => 'Kepala Tata Usaha',
                'petunjuk' => 'Siapkan dokumen pendukung',
                'catatan' => 'Lampirkan rekap kegiatan semester sebelumnya',
                'isi_disposisi' => 'Mohon data disiapkan sebelum kunjungan.',
                'disposisi_kasubbag' => 'Segera disiapkan',
                'file' => 'surat_masuk/sm-2026-0003.pdf',
            ],
        ];

        foreach ($data as $item) {
            SuratMasuk::updateOrCreate(
                ['nomor_surat' => $item['nomor_surat']],
                $item
            );
        }
    }
}